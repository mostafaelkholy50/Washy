<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
            'facebook' => 'nullable|string', // Relaxed from url
            'twitter' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'instagram' => 'nullable|string',
        ]);

        $data = $request->all();

        // Manual translation mapping for simple create form
        // Assuming Member model uses HasTranslations for 'name' and 'job_title'
        $member = new Member();
        $member->setTranslation('name', 'en', $request->name);
        $member->setTranslation('name', 'ar', $request->name);
        $member->setTranslation('job_title', 'en', $request->role);
        $member->setTranslation('job_title', 'ar', $request->role);

        $member->facebook = $request->facebook;
        $member->twitter = $request->twitter;
        $member->linkedin = $request->linkedin;
        $member->instagram = $request->instagram;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $destinationPath = public_path('images/members');
            if (!file_exists($destinationPath))
                mkdir($destinationPath, 0755, true);
            $request->image->move($destinationPath, $imageName);
            $member->image = 'images/members/' . $imageName;
        }

        $member->save();

        return redirect()->route('admin.members.index')->with('success', 'تم إضافة العضو بنجاح.');
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'job_title_en' => 'required|string|max:255',
            'job_title_ar' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'facebook' => 'nullable|string',
            'twitter' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'instagram' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($member->image && file_exists(public_path($member->image))) {
                unlink(public_path($member->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $destinationPath = public_path('images/members');
            if (!file_exists($destinationPath))
                mkdir($destinationPath, 0755, true);
            $request->image->move($destinationPath, $imageName);
            $data['image'] = 'images/members/' . $imageName;
        }

        $member->setNameEnAttribute($request->name_en);
        $member->setNameArAttribute($request->name_ar);

        // Note: The controller used 'role' but model used 'job_title'. aligning to model.
        $member->setJobTitleEnAttribute($request->job_title_en);
        $member->setJobTitleArAttribute($request->job_title_ar);

        $member->facebook = $request->facebook;
        $member->twitter = $request->twitter;
        $member->linkedin = $request->linkedin;
        $member->instagram = $request->instagram;

        if (isset($data['image']))
            $member->image = $data['image'];

        $member->save();

        return redirect()->route('admin.members.index')->with('success', 'تم تحديث العضو بنجاح.');
    }

    public function destroy(Member $member)
    {
        if ($member->image && file_exists(public_path($member->image))) {
            unlink(public_path($member->image));
        }
        $member->delete();
        return redirect()->route('admin.members.index')->with('success', 'تم حذف العضو بنجاح.');
    }
}
