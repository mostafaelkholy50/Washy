<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
        ]);

        $category = new Category();
        $category->setTranslation('name', 'en', $request->name_en);
        $category->setTranslation('name', 'ar', $request->name_ar);
        
        // Auto-generate slugs
        $category->setTranslation('slug', 'en', \Illuminate\Support\Str::slug($request->name_en));
        $category->setTranslation('slug', 'ar', \Illuminate\Support\Str::slug($request->name_ar)); // Or use same slug if preferred, but separate is safer for unique checks
        
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'تم إضافة القسم بنجاح.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
        ]);

        $category->setTranslation('name', 'en', $request->name_en);
        $category->setTranslation('name', 'ar', $request->name_ar);
        
        // Update slugs only if names changed (or always, to keep them synced)
        $category->setTranslation('slug', 'en', \Illuminate\Support\Str::slug($request->name_en));
        $category->setTranslation('slug', 'ar', \Illuminate\Support\Str::slug($request->name_ar));
        
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'تم تحديث القسم بنجاح.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'تم حذف القسم بنجاح.');
    }
}
