<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Category;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::with('category')->get();
        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.portfolios.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|max:2048',
        ]);

        $portfolio = new Portfolio();
        $portfolio->setTranslation('title', 'en', $request->title_en);
        $portfolio->setTranslation('title', 'ar', $request->title_ar);
        $portfolio->setTranslation('description', 'en', $request->description_en);
        $portfolio->setTranslation('description', 'ar', $request->description_ar);
        $portfolio->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $destinationPath = public_path('images/portfolios');
            if (!file_exists($destinationPath))
                mkdir($destinationPath, 0755, true);
            $request->image->move($destinationPath, $imageName);
            $portfolio->image = 'images/portfolios/' . $imageName;
        }

        $portfolio->save();

        return redirect()->route('admin.portfolios.index')->with('success', 'تم إضافة العمل بنجاح.');
    }

    public function edit(Portfolio $portfolio)
    {
        $categories = Category::all();
        return view('admin.portfolios.edit', compact('portfolio', 'categories'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $portfolio->setTranslation('title', 'en', $request->title_en);
        $portfolio->setTranslation('title', 'ar', $request->title_ar);
        $portfolio->setTranslation('description', 'en', $request->description_en);
        $portfolio->setTranslation('description', 'ar', $request->description_ar);
        $portfolio->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            if ($portfolio->image && file_exists(public_path($portfolio->image))) {
                unlink(public_path($portfolio->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $destinationPath = public_path('images/portfolios');
            if (!file_exists($destinationPath))
                mkdir($destinationPath, 0755, true);
            $request->image->move($destinationPath, $imageName);
            $portfolio->image = 'images/portfolios/' . $imageName;
        }

        $portfolio->save();

        return redirect()->route('admin.portfolios.index')->with('success', 'تم تحديث العمل بنجاح.');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->image && file_exists(public_path($portfolio->image))) {
            unlink(public_path($portfolio->image));
        }
        $portfolio->delete();
        return redirect()->route('admin.portfolios.index')->with('success', 'تم حذف العمل بنجاح.');
    }
}
