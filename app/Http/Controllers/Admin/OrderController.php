<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->latest()->get();
        return view('admin.orders.index', compact('orders'));
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
        return view('admin.orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'currency' => 'required|string|size:3',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // 1. إنشاء الطلب (إجمالي مبدئي 0)
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'date' => $request->date,
                'type' => $request->type,
                'currency' => $request->currency,
                'total' => 0,
                'note' => $request->note,
            ]);

            $grandTotal = 0;

            // 2. إضافة العناصر وحساب الإجمالي
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

            // 3. تحديث إجمالي الطلب
            $order->update(['total' => $grandTotal]);

            // 4. خصم من الرصيد وتحديث الملاحظة (History)
            $balance = $order->customer->balance;
            if ($balance) {
                // decrement بتقلل القيمة برمجياً حتى لو النتيجة سالبة
                $balance->decrement('amount', $grandTotal);

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
                // إرجاع المبلغ للرصيد (لو كان -20 وهنرجع 50 هيبقى 30)
                $balance->increment('amount', $total);

                $dateStr = ($order->date instanceof \Carbon\Carbon) ? $order->date->format('Y-m-d') : $order->date;
                $historyNote = "إرجاع مبلغ طلب محذوف رقم #{$order->id} (بتاريخ " . $dateStr . ")";
                $balance->update(['note' => $historyNote]);
            }

            // الحذف الفعلي للطلب
            $order->delete();

            DB::commit();
            return redirect()->route('admin.orders.index')
                ->with('warning', 'تم حذف الطلب وإعادة مبلغ ' . number_format($total, 2) . ' ' . ($balance->currency ?? 'EGP') . ' للرصيد.');

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
