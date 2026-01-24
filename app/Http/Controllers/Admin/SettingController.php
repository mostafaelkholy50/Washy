<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create(['site_name' => 'Default Site Name']);
        }
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name_ar' => 'required|string|max:255',
            'site_name_en' => 'required|string|max:255',
            'welcome_title_ar' => 'nullable|string',
            'welcome_title_en' => 'nullable|string',
            'welcome_btn_1_text_ar' => 'nullable|string|max:50',
            'welcome_btn_1_text_en' => 'nullable|string|max:50',
            'welcome_btn_1_link' => 'nullable|string|max:255',
            'welcome_btn_2_text_ar' => 'nullable|string|max:50',
            'welcome_btn_2_text_en' => 'nullable|string|max:50',
            'welcome_btn_2_link' => 'nullable|string|max:255',

            // About
            'about_title_ar' => 'nullable|string|max:255',
            'about_title_en' => 'nullable|string|max:255',
            'about_description_ar' => 'nullable|string',
            'about_description_en' => 'nullable|string',

            // Team
            'team_title_ar' => 'nullable|string|max:255',
            'team_title_en' => 'nullable|string|max:255',
            'team_description_ar' => 'nullable|string',
            'team_description_en' => 'nullable|string',

            // Services
            'services_title_ar' => 'nullable|string|max:255',
            'services_title_en' => 'nullable|string|max:255',
            'services_description_ar' => 'nullable|string',
            'services_description_en' => 'nullable|string',
            'services_sub_title_ar' => 'nullable|string|max:255',
            'services_sub_title_en' => 'nullable|string|max:255',
            'services_sub_description_ar' => 'nullable|string',
            'services_sub_description_en' => 'nullable|string',

            // Contact
            'contact_title_ar' => 'nullable|string|max:255',
            'contact_title_en' => 'nullable|string|max:255',
            'contact_description_ar' => 'nullable|string',
            'contact_description_en' => 'nullable|string',
            'cta_text_ar' => 'nullable|string',
            'cta_text_en' => 'nullable|string',
            'cta_button1_text_ar' => 'nullable|string|max:50',
            'cta_button1_text_en' => 'nullable|string|max:50',
            'cta_button2_text_ar' => 'nullable|string|max:50',
            'cta_button2_text_en' => 'nullable|string|max:50',

            'address_ar' => 'nullable|string',
            'address_en' => 'nullable|string',

            'email' => 'nullable|email',
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:1024',
            'top_banner' => 'nullable|image|max:2048',
            'linkedin' => 'nullable|string|max:255',
            'news_ticker_bg_color' => 'nullable|string|max:7',
            'news_ticker_text_color' => 'nullable|string|max:7',
            'primary_color' => 'nullable|string|max:7',
            'phone' => 'nullable|string|max:50',
        ]);

        $setting = Setting::first();
        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($setting->logo && file_exists(public_path($setting->logo))) {
                unlink(public_path($setting->logo));
            }
            $logoName = 'logo_' . time() . '.' . $request->logo->extension();
            $destinationPath = public_path('images');
            if (!file_exists($destinationPath))
                mkdir($destinationPath, 0755, true);
            $request->logo->move($destinationPath, $logoName);
            $data['logo'] = 'images/' . $logoName;
        }

        if ($request->hasFile('favicon')) {
            if ($setting->favicon && file_exists(public_path($setting->favicon))) {
                unlink(public_path($setting->favicon));
            }
            $favName = 'favicon_' . time() . '.' . $request->favicon->extension();
            $destinationPath = public_path('icon');
            if (!file_exists($destinationPath))
                mkdir($destinationPath, 0755, true);
            $request->favicon->move($destinationPath, $favName);
            $data['favicon'] = 'icon/' . $favName;
        }

        if ($request->hasFile('top_banner')) {
            if ($setting->top_banner && file_exists(public_path($setting->top_banner))) {
                unlink(public_path($setting->top_banner));
            }
            $bannerName = 'top_banner_' . time() . '.' . $request->top_banner->extension();
            $destinationPath = public_path('images');
            if (!file_exists($destinationPath))
                mkdir($destinationPath, 0755, true);
            $request->top_banner->move($destinationPath, $bannerName);
            $data['top_banner'] = 'images/' . $bannerName;
        }

        $setting->update($data);

        return redirect()->back()->with('success', 'تم تحديث الإعدادات بنجاح.');
    }
}
