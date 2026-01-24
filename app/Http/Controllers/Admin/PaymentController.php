<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Balance;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('customer')->latest()->get();
        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        return view('admin.payments.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|size:3',
            'payment_method' => 'required|string|max:100',
            'note' => 'nullable|string',
        ]);

        $payment = Payment::create($validated);

        // زيادة الرصيد (الدفعة = فلوس جت من العميل → الرصيد يزيد)
        $balance = Balance::firstOrCreate(
            ['customer_id' => $payment->customer_id],
            ['amount' => 0.00, 'note' => 'تم إنشاء الرصيد تلقائيًا']
        );

        $balance->increment('amount', $payment->amount);

        // تحديث الـ note اختياري
        $balance->update([
            'note' => trim("دفعة بقيمة {$payment->amount} {$payment->currency} - {$payment->date->format('Y-m-d')}"),
            'currency' => $payment->currency,
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
            $balance->decrement('amount', $amount);

            // تحديث الملاحظة اختياري
            $balance->update([
                'note' => trim(($balance->note ? $balance->note . ' | ' : '') . "حذف دفعة بقيمة {$amount} {$payment->currency} (تم طرحها من الرصيد)")
            ]);
        }

        return redirect()
            ->route('admin.payments.index')
            ->with('warning', "تم حذف الدفعة وقد تم خصم {$amount} {$payment->currency} من رصيد العميل.");
    }
}