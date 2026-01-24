<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$app->instance('request', $request);

$locale = $_GET['lang'] ?? 'ar';
app()->setLocale($locale);

echo "Current Locale: " . app()->getLocale() . "<br>";
echo "Menu Home: " . __('menu.home') . "<br>";
echo "Menu About: " . __('menu.about') . "<br>";
echo "General All: " . __('general.all') . "<br>";
echo "General Read More: " . __('general.read_more') . "<br>";
echo "<br><a href='?lang=ar'>العربية</a> | <a href='?lang=en'>English</a>";
