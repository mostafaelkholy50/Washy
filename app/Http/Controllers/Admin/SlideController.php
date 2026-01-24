<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    public function index()
    {
        $slides = Slide::orderBy('sort_order')->get();
        return view('admin.slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.slides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Background
            'foreground_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Foreground
            'title_en' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'sort_order' => 'integer',
        ]);

        $data = $request->except(['image', 'foreground_image', 'title_en', 'title_ar', 'title']);
        $slide = new Slide();
        $slide->fill($data);

        $slide->setTitleEnAttribute($request->title_en);
        $slide->setTitleArAttribute($request->title_ar);

        if ($request->hasFile('image')) {
            $imageName = time() . '_bg.' . $request->image->extension();
            $destinationPath = public_path('images/slider');
            if (!file_exists($destinationPath))
                mkdir($destinationPath, 0755, true);
            $request->image->move($destinationPath, $imageName);
            $slide->image = 'images/slider/' . $imageName;
        }

        if ($request->hasFile('foreground_image')) {
            $fgName = time() . '_fg.' . $request->foreground_image->extension();
            $destinationPath = public_path('images/slider');
            if (!file_exists($destinationPath))
                mkdir($destinationPath, 0755, true);
            $request->foreground_image->move($destinationPath, $fgName);
            $slide->foreground_image = 'images/slider/' . $fgName;
        }

        $slide->save();

        return redirect()->route('admin.slides.index')->with('success', 'تم إنشاء الشريحة بنجاح.');
    }

    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', compact('slide'));
    }

    public function update(Request $request, Slide $slide)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foreground_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title_en' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'sort_order' => 'integer',
        ]);

        $data = $request->except(['image', 'foreground_image', 'title_en', 'title_ar', 'title']);
        $slide->fill($data);

        $slide->setTitleEnAttribute($request->title_en);
        $slide->setTitleArAttribute($request->title_ar);

        if ($request->hasFile('image')) {
            // Delete old background
            if (file_exists(public_path($slide->image))) {
                unlink(public_path($slide->image));
            }
            $imageName = time() . '_bg.' . $request->image->extension();
            $destinationPath = public_path('images/slider');
            if (!file_exists($destinationPath))
                mkdir($destinationPath, 0755, true);
            $request->image->move($destinationPath, $imageName);
            $slide->image = 'images/slider/' . $imageName;
        }

        if ($request->hasFile('foreground_image')) {
            // Delete old foreground
            if ($slide->foreground_image && file_exists(public_path($slide->foreground_image))) {
                unlink(public_path($slide->foreground_image));
            }
            $fgName = time() . '_fg.' . $request->foreground_image->extension();
            $destinationPath = public_path('images/slider');
            if (!file_exists($destinationPath))
                mkdir($destinationPath, 0755, true);
            $request->foreground_image->move($destinationPath, $fgName);
            $slide->foreground_image = 'images/slider/' . $fgName;
        }

        $slide->save();

        return redirect()->route('admin.slides.index')->with('success', 'تم تحديث الشريحة بنجاح.');
    }

    public function destroy(Slide $slide)
    {
        if (file_exists(public_path($slide->image))) {
            unlink(public_path($slide->image));
        }
        if ($slide->foreground_image && file_exists(public_path($slide->foreground_image))) {
            unlink(public_path($slide->foreground_image));
        }
        $slide->delete();
        return redirect()->route('admin.slides.index')->with('success', 'تم حذف الشريحة بنجاح.');
    }
}
