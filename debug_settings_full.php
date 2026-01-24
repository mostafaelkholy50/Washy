<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$settings = \App\Models\Setting::all();

echo "Found " . $settings->count() . " settings records.\n";
foreach ($settings as $setting) {
    echo "ID: {$setting->id}\n";
    echo "Updated At: {$setting->updated_at}\n";
    echo "About Title: {$setting->about_title}\n";
    echo "Services Title: {$setting->services_title}\n";
    echo "---------------------------------\n";
}
