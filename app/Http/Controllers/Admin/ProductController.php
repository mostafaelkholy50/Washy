<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Currency;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * عرض كل المنتجات
     */
    public function index(Request $request)
    {
        $query = Product::with('currency_rel');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        // Filter by Currency
        if ($request->filled('currency_id')) {
            $query->where('currency_id', $request->currency_id);
        }

        // Sorting
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        $allowedSorts = ['name', 'price', 'type'];

        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }

        $products = $query->paginate(20)->withQueryString();
        $currencies = Currency::all();

        return view('admin.products.index', compact('products', 'currencies'));
    }

    /**
     * عرض نموذج إضافة منتج جديد
     */
    public function create()
    {
        $currencies = Currency::all();
        $favoriteCurrency = Currency::where('is_favorite', true)->first();
        return view('admin.products.create', compact('currencies', 'favoriteCurrency'));
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * حفظ منتج جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|size:3',
            'currency_id' => 'required|exists:currencies,id',
            'note' => 'nullable|string',
        ]);

        if (empty($validated['currency'])) {
            $currency = Currency::find($validated['currency_id']);
            $validated['currency'] = $currency->code;
        }

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح.');
    }

    /**
     * عرض نموذج تعديل المنتج
     */
    public function edit(Product $product)
    {
        $currencies = Currency::all();
        return view('admin.products.edit', compact('product', 'currencies'));
    }

    /**
     * تحديث بيانات المنتج
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|size:3',
            'currency_id' => 'required|exists:currencies,id',
            'note' => 'nullable|string',
        ]);

        if (empty($validated['currency'])) {
            $currency = Currency::find($validated['currency_id']);
            $validated['currency'] = $currency->code;
        }

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'تم تحديث بيانات المنتج بنجاح.');
    }

    /**
     * حذف المنتج
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح.');
    }
}