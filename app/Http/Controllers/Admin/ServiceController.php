<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'icon' => 'nullable|string|max:255', // Assuming icon class string for now
        ]);

        $service = new Service();
        $service->setTranslation('title', 'en', $request->title_en);
        $service->setTranslation('title', 'ar', $request->title_ar);
        $service->setTranslation('description', 'en', $request->description_en);
        $service->setTranslation('description', 'ar', $request->description_ar);
        $service->icon = $request->icon;

        $service->save();

        return redirect()->route('admin.services.index')->with('success', 'تم إضافة الخدمة بنجاح.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
             'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        $service->setTranslation('title', 'en', $request->title_en);
        $service->setTranslation('title', 'ar', $request->title_ar);
         $service->setTranslation('description', 'en', $request->description_en);
        $service->setTranslation('description', 'ar', $request->description_ar);
        $service->icon = $request->icon;

        $service->save();

        return redirect()->route('admin.services.index')->with('success', 'تم تحديث الخدمة بنجاح.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'تم حذف الخدمة بنجاح.');
    }
}
