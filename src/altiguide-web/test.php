<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$m = new \App\Models\Mountain();
$m->name = 'Test Mountain';
$m->location = 'Loc';
$m->altitude = 1200;
echo "Slug before save: " . $m->slug . "\n";
$m->save();
echo "Slug after save: " . $m->slug . "\n";
