<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::all();
        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        return view('admin.skills.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'percentage' => 'required|integer|min:0|max:100',
        ]);

        $skill = new Skill();
        $skill->setTranslation('name', 'en', $request->name_en);
        $skill->setTranslation('name', 'ar', $request->name_ar); 
        
        $skill->percent = $request->percentage;

        $skill->save();

        return redirect()->route('admin.skills.index')->with('success', 'تم إضافة المهارة بنجاح.');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'percentage' => 'required|integer|min:0|max:100',
        ]);

        $skill->setTranslation('name', 'en', $request->name_en);
        $skill->setTranslation('name', 'ar', $request->name_ar);
        
        $skill->percent = $request->percentage;

        $skill->save();

        return redirect()->route('admin.skills.index')->with('success', 'تم تحديث المهارة بنجاح.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('admin.skills.index')->with('success', 'تم حذف المهارة بنجاح.');
    }
}
