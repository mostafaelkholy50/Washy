<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Delete ID 1
\App\Models\Setting::where('id', 1)->delete();

echo "Deleted ID 1. Remaining count: " . \App\Models\Setting::count() . "\n";
