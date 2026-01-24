<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TimelineController extends Controller
{
    public function index()
    {
        $timelines = Timeline::latest()->get();
        return view('admin.timelines.index', compact('timelines'));
    }

    public function create()
    {
        return view('admin.timelines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
        ]);

        $timeline = new Timeline();
        $timeline->year = $request->year;
        $timeline->title_en = $request->title_en;
        $timeline->title_ar = $request->title_ar;
        $timeline->description_en = $request->description_en;
        $timeline->description_ar = $request->description_ar;

        $timeline->save();

        return redirect()->route('admin.timelines.index')->with('success', __('general.created_successfully'));
    }

    public function edit(Timeline $timeline)
    {
        return view('admin.timelines.edit', compact('timeline'));
    }

    public function update(Request $request, Timeline $timeline)
    {
        $request->validate([
            'year' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
        ]);

        $timeline->year = $request->year;
        $timeline->title_en = $request->title_en;
        $timeline->title_ar = $request->title_ar;
        $timeline->description_en = $request->description_en;
        $timeline->description_ar = $request->description_ar;

        $timeline->save();

        return redirect()->route('admin.timelines.index')->with('success', __('general.updated_successfully'));
    }

    public function destroy(Timeline $timeline)
    {
        $timeline->delete();
        return redirect()->route('admin.timelines.index')->with('success', __('general.deleted_successfully'));
    }
}
