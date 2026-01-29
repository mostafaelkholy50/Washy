<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Balance;
use App\Models\Currency;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['customer', 'currency_rel']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Filter by Date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        // Filter by Method
        if ($request->filled('method')) {
            $query->where('payment_method', $request->input('method'));
        }

        // Sorting
        $sort = $request->get('sort', 'date');
        $direction = $request->get('direction', 'desc');
        $allowedSorts = ['id', 'date', 'amount'];

        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('date', 'desc')->orderBy('id', 'desc');
        }

        $payments = $query->paginate(20)->withQueryString();

        // Get unique methods for filter dropdown
        $paymentMethods = Payment::distinct()->pluck('payment_method');

        return view('admin.payments.index', compact('payments', 'paymentMethods'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $currencies = Currency::all();
        $favoriteCurrency = Currency::where('is_favorite', true)->first();
        return view('admin.payments.create', compact('customers', 'currencies', 'favoriteCurrency'));
    }

    public function edit(Payment $payment)
    {
        $customers = Customer::orderBy('name')->get();
        $currencies = Currency::all();
        return view('admin.payments.edit', compact('payment', 'customers', 'currencies'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'nullable|string|size:3',
            'currency_id' => 'required|exists:currencies,id',
            'payment_method' => 'required|string|max:100',
            'note' => 'nullable|string',
        ]);

        if (empty($validated['currency'])) {
            $currency = Currency::find($validated['currency_id']);
            $validated['currency'] = $currency->code;
        }

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $oldAmount = $payment->amount;
            $oldCustomerId = $payment->customer_id;

            // 1. خصم المبلغ القديم من رصيد العميل القديم
            $oldBalance = Balance::where('customer_id', $oldCustomerId)->first();
            if ($oldBalance) {
                $oldBalance->decrement('amount', (float) $oldAmount);
            }

            // 2. تحديث بيانات الدفعة
            $payment->update($validated);

            // 3. إضافة المبلغ الجديد لرصيد العميل الجديد
            $newBalance = Balance::firstOrCreate(
                ['customer_id' => $payment->customer_id],
                ['amount' => 0.00, 'note' => 'تم إنشاء الرصيد تلقائيًا']
            );
            $newBalance->increment('amount', (float) $payment->amount);

            // 4. تحديث ملاحظة الرصيد
            $newBalance->update([
                'note' => trim("تعديل دفعة بقيمة {$payment->amount} {$payment->currency} - " . \Carbon\Carbon::parse($payment->date)->format('Y-m-d')),
                'currency' => $payment->currency,
                'currency_id' => $payment->currency_id,
            ]);

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('admin.payments.index')->with('success', 'تم تحديث الدفعة وتعديل الرصيد بنجاح.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollback();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    public function show(Payment $payment)
    {
        $payment->load('customer');
        return view('admin.payments.show', compact('payment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'nullable|string|size:3',
            'currency_id' => 'required|exists:currencies,id',
            'payment_method' => 'required|string|max:100',
            'note' => 'nullable|string',
        ]);

        if (empty($validated['currency'])) {
            $currency = Currency::find($validated['currency_id']);
            $validated['currency'] = $currency->code;
        }

        $payment = Payment::create($validated);

        // زيادة الرصيد (الدفعة = فلوس جت من العميل → الرصيد يزيد)
        $balance = Balance::firstOrCreate(
            ['customer_id' => $payment->customer_id],
            ['amount' => 0.00, 'note' => 'تم إنشاء الرصيد تلقائيًا']
        );

        $balance->increment('amount', (float) $payment->amount);

        // تحديث الـ note اختياري
        $balance->update([
            'note' => trim("دفعة بقيمة {$payment->amount} {$payment->currency} - " . \Carbon\Carbon::parse($payment->date)->format('Y-m-d')),
            'currency' => $payment->currency,
            'currency_id' => $payment->currency_id,
        ]);


        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'تم تسجيل الدفعة وإضافتها إلى رصيد العميل بنجاح.');
    }

    public function destroy(Payment $payment)
    {
        $customerId = $payment->customer_id;
        $amount = $payment->amount;

        $payment->delete();

        // طرح المبلغ من الرصيد
        $balance = Balance::where('customer_id', $customerId)->first();

        if ($balance) {
            $balance->decrement('amount', (float) $amount);

            // تحديث الملاحظة اختياري
            $balance->update([
                'note' => trim(($balance->note ? $balance->note . ' | ' : '') . "حذف دفعة بقيمة {$amount} {$payment->currency} (تم طرحها من الرصيد)")
            ]);
        }

        return redirect()
            ->route('admin.payments.index')
            ->with('warning', "تم حذف الدفعة وقد تم خصم {$amount} {$payment->currency} من رصيد العميل.");
    }
    public function printView(Payment $payment)
    {
        $payment->load('customer', 'currency_rel');

        return view('admin.payments.print', compact('payment'));
    }
}
