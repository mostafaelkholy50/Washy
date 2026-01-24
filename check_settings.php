<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$setting = \App\Models\Setting::first();

if ($setting) {
    echo "Settings Found (ID: {$setting->id})\n";
    echo "---------------------------------\n";
    echo "About Title: " . $setting->about_title . "\n";
    echo "Services Title: " . $setting->services_title . "\n";
    echo "Portfolio Title: " . $setting->portfolio_title . "\n";
    
    // Check if the columns actually exist in the attributes
    $attributes = $setting->getAttributes();
    echo "Columns present in model: " . (array_key_exists('services_title', $attributes) ? 'Yes' : 'No') . "\n";
} else {
    echo "No settings record found.\n";
}
