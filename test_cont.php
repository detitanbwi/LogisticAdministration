<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo json_encode(array_slice(App\Models\Container::with('kapal')->get(['id', 'nomor_container', 'etd', 'kapal_id'])->toArray(), -10), JSON_PRETTY_PRINT);
