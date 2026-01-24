<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        Setting::create([
            'site_name' => 'Zero One for Software Development',
            'email' => 'info@zeroone.com',
            'phone' => '+201234567890',
            'address' => 'Cairo, Egypt',
            'about_footer' => 'Leading software development company providing innovative solutions.',
        ]);
    }
}
