<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking table structures...\n\n";

// Check tabla_actividad_parque structure
echo "tabla_actividad_parque columns:\n";
$columns = DB::select("SHOW COLUMNS FROM tabla_actividad_parque");
foreach ($columns as $column) {
    echo "- {$column->Field}\n";
}

echo "\nSample data from tabla_actividad_parque:\n";
$sample = DB::table('tabla_actividad_parque')->limit(3)->get();
foreach ($sample as $row) {
    $data = (array)$row;
    echo "- " . json_encode(array_slice($data, 0, 3), JSON_UNESCAPED_UNICODE) . "...\n";
}

echo "\nChecking municipios table structure (for locality mapping):\n";
$columns = DB::select("SHOW COLUMNS FROM municipios");
foreach ($columns as $column) {
    echo "- {$column->Field}\n";
}

echo "\nSample municipios data:\n";
$sample = DB::table('municipios')->limit(3)->get();
foreach ($sample as $row) {
    $data = (array)$row;
    echo "- " . json_encode(array_slice($data, 0, 4), JSON_UNESCAPED_UNICODE) . "...\n";
}
