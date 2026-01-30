<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer.balance', 'currency_rel']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($cq) use ($search) {
                        $cq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by Date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        // Filter by Order Type
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        // Sorting
        $sort = $request->get('sort', 'date');
        $direction = $request->get('direction', 'desc');
        $allowedSorts = ['id', 'date', 'total'];

        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('date', 'desc')->orderBy('id', 'desc');
        }

        if ($request->has('print')) {
            $orders = $query->get();
            return view('admin.orders.print_all', compact('orders'));
        }

        $orders = $query->paginate(20)->withQueryString();

        // Get unique types for filter dropdown
        $orderTypes = Order::whereNotNull('type')->distinct()->pluck('type');

        return view('admin.orders.index', compact('orders', 'orderTypes'));
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $currencies = Currency::all();
        $favoriteCurrency = Currency::where('is_favorite', true)->first();
        return view('admin.orders.create', compact('customers', 'products', 'currencies', 'favoriteCurrency'));
    }

    public function edit(Order $order)
    {
        $order->load('items');
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $currencies = Currency::all();
        return view('admin.orders.edit', compact('order', 'customers', 'products', 'currencies'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'currency_id' => 'required|exists:currencies,id',
            'type' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $oldTotal = $order->total;
            $oldCustomer = $order->customer;

            // 1. إرجاع المبلغ القديم للرصيد
            if ($oldCustomer && $oldCustomer->balance) {
                $oldCustomer->balance->increment('amount', (float) $oldTotal);
            }

            // 2. تحديث بيانات الطلب
            $currency = Currency::find($request->currency_id);
            $type = $request->input('type');
            if (blank($type)) {
                $type = ' ';
            }

            $order->update([
                'customer_id' => $request->customer_id,
                'date' => $request->date,
                'type' => $type,
                'currency' => $currency->code,
                'currency_id' => $request->currency_id,
                'note' => $request->note,
            ]);

            $order->items()->delete();
            $grandTotal = 0;
            foreach ($request->items as $itemData) {
                $product = Product::find($itemData['product_id']);
                $subtotal = $product->price * $itemData['quantity'];

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $grandTotal += $subtotal;
            }

            $order->update(['total' => $grandTotal]);

            $newCustomer = Customer::find($request->customer_id);
            if ($newCustomer && $newCustomer->balance) {
                $newCustomer->balance->decrement('amount', (float) $grandTotal);

                $dateStr = ($order->date instanceof \Carbon\Carbon) ? $order->date->format('Y-m-d') : $order->date;
                $historyNote = "تعديل طلب رقم #{$order->id} بتاريخ " . $dateStr;
                $newCustomer->balance->update(['note' => $historyNote]);
            }

            DB::commit();
            return redirect()->route('admin.orders.index')->with('success', 'تم تحديث الطلب وتعديل الرصيد بنجاح.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'currency' => 'nullable|string|size:3',
            'currency_id' => 'required|exists:currencies,id',
            'type' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $currency_code = $request->currency;
        if (empty($currency_code)) {
            $currency = Currency::find($request->currency_id);
            $currency_code = $currency->code;
        }
        $type = $request->input('type');

        if (blank($type)) {
            $type = ' ';
        }
        try {
            DB::beginTransaction();

            $order = Order::create([
                'customer_id' => $request->customer_id,
                'date' => $request->date,
                'type' => $type,
                'currency' => $currency_code,
                'currency_id' => $request->currency_id,
                'total' => 0,
                'note' => $request->note,
            ]);

            $grandTotal = 0;

            foreach ($request->items as $itemData) {
                $product = Product::find($itemData['product_id']);
                $subtotal = $product->price * $itemData['quantity'];

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $grandTotal += $subtotal;
            }

            $order->update(['total' => $grandTotal]);

            $balance = $order->customer->balance;
            if ($balance) {
                $balance->decrement('amount', (float) $grandTotal);

                $dateStr = ($order->date instanceof \Carbon\Carbon) ? $order->date->format('Y-m-d') : $order->date;
                $historyNote = "خصم مقابل طلب رقم #{$order->id} بتاريخ " . $dateStr;
                $balance->update(['note' => $historyNote]);
            }

            DB::commit();
            return redirect()->route('admin.orders.index')
                ->with('success', 'تم تسجيل الطلب وخصم ' . number_format($grandTotal, 2) . ' ' . $balance->currency . ' من الرصيد.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();

            $total = $order->total;
            $balance = $order->customer->balance;

            if ($balance) {
                $balance->increment('amount', (float) $total);

                $dateStr = ($order->date instanceof \Carbon\Carbon) ? $order->date->format('Y-m-d') : $order->date;
                $historyNote = "إرجاع مبلغ طلب محذوف رقم #{$order->id} (بتاريخ " . $dateStr . ")";
                $balance->update(['note' => $historyNote]);
            }

            $order->delete();

            DB::commit();
            return redirect()->route('admin.orders.index')
                ->with('warning', 'تم حذف الطلب وإعادة مبلغ ' . number_format((float) $total, 2) . ' ' . ($balance->currency ?? 'EGP') . ' للرصيد.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    public function downloadPdf(Order $order)
    {
        $order->load(['customer.balance', 'items.product']);
        $setting = Setting::first();

        $pdf = PDF::loadView('admin.orders.pdf', [
            'order' => $order,
            'setting' => $setting
        ], [], [
            'format' => 'A4',
            'display_mode' => 'fullpage',
            'default_font' => 'cairo',
            'orientation' => 'P',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'auto_arabic' => true,
        ]);

        return $pdf->download("order-{$order->id}.pdf");
    }
    public function printView(Order $order)
    {
        $order->load(['customer.balance', 'items.product']);

        return view('admin.orders.print', compact('order'));
    }
}
