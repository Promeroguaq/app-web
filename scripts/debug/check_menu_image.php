<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking tabla_imagenes structure...\n\n";

$columns = \Schema::getColumnListing('tabla_imagenes');
echo "Columns:\n";
foreach ($columns as $col) {
    echo "  - $col\n";
}

echo "\n\nSample data (first 3):\n";
$sample = \DB::table('tabla_imagenes')->limit(3)->get();
foreach ($sample as $row) {
    echo "  " . json_encode((array)$row, JSON_UNESCAPED_UNICODE) . "\n";
}
