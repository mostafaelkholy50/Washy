<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * عرض كل العملاء
     */
    public function index()
    {
        $customers = Customer::latest()->get(); // أو paginate(15) لو عايز ترقيم صفحات
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * عرض نموذج إضافة عميل جديد
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * حفظ عميل جديد
     */
public function show(Customer $customer)
{
    $customer->load([
        'balance',
        'orders.items.product',
        'payments' => fn($q) => $q->latest(),
    ]);

    return view('admin.customers.show', compact('customer'));
}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_whatsapp' => 'nullable|string|max:20|unique:customers,phone_whatsapp',
            'phone' => 'nullable|string|max:20',
            'street' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:100',
            'piece' => 'nullable|string|max:50',
            'house_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        Customer::create($validated);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'تم إضافة العميل بنجاح.');
    }

    /**
     * عرض نموذج تعديل العميل
     */
    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * تحديث بيانات العميل
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_whatsapp' => 'nullable|string|max:20|unique:customers,phone_whatsapp,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'street' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:100',
            'piece' => 'nullable|string|max:50',
            'house_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $customer->update($validated);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'تم تحديث بيانات العميل بنجاح.');
    }

    /**
     * حذف العميل
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'تم حذف العميل بنجاح.');
    }
}