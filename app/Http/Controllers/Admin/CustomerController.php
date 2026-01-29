<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Currency;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        $query = Customer::with(['balance', 'currency']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone_whatsapp', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('area', 'like', "%{$search}%");
            });
        }

        if ($request->filled('currency_id')) {
            $query->where('currency_id', $request->currency_id);
        }

        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $allowedSorts = ['name', 'created_at', 'area'];

        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }

        $customers = $query->paginate(20)->withQueryString();
        $currencies = Currency::all();

        return view('admin.customers.index', compact('customers', 'currencies'));
    }


    public function create()
    {
        $currencies = Currency::all();
        $favoriteCurrency = Currency::where('is_favorite', true)->first();
        return view('admin.customers.create', compact('currencies', 'favoriteCurrency'));
    }

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
            'preferred_currency' => 'nullable|string|size:3',
            'currency_id' => 'required|exists:currencies,id',
        ]);

        if (empty($validated['preferred_currency'])) {
            $currency = Currency::find($validated['currency_id']);
            $validated['preferred_currency'] = $currency->code;
        }

        Customer::create($validated);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'تم إضافة العميل بنجاح.');
    }

    public function edit(Customer $customer)
    {
        $currencies = Currency::all();
        return view('admin.customers.edit', compact('customer', 'currencies'));
    }


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
            'preferred_currency' => 'nullable|string|size:3',
            'currency_id' => 'required|exists:currencies,id',
        ]);

        if (empty($validated['preferred_currency'])) {
            $currency = Currency::find($validated['currency_id']);
            $validated['preferred_currency'] = $currency->code;
        }

        $customer->update($validated);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'تم تحديث بيانات العميل بنجاح.');
    }


    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'تم حذف العميل بنجاح.');
    }
}
