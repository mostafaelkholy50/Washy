<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * عرض كل المنتجات
     */
    public function index()
    {
        $products = Product::latest()->get(); // أو paginate(15) لو عايز ترقيم
        return view('admin.products.index', compact('products'));
    }

    /**
     * عرض نموذج إضافة منتج جديد
     */
    public function create()
    {
        return view('admin.products.create');
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
            'currency' => 'required|string|size:3',
            'note' => 'nullable|string',
        ]);

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
        return view('admin.products.edit', compact('product'));
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
            'currency' => 'required|string|size:3',
            'note' => 'nullable|string',
        ]);

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