<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking municipios table structure in detail...\n\n";

// Check both municipios and tabla_municipios
$tables = ['municipios', 'tabla_municipios'];

foreach ($tables as $tableName) {
    echo "=== $tableName table ===\n";
    try {
        $columns = DB::select("SHOW COLUMNS FROM $tableName");
        foreach ($columns as $column) {
            echo "- {$column->Field}\n";
        }
        
        echo "\nSample data:\n";
        $sample = DB::table($tableName)->limit(3)->get();
        foreach ($sample as $row) {
            $data = (array)$row;
            echo "- " . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n";
        }
        echo "\n";
    } catch (Exception $e) {
        echo "Table $tableName not found: " . $e->getMessage() . "\n\n";
    }
}

// Check if there's any relationship between municipalities and departments
echo "=== Checking for relationships ===\n";
try {
    $sample = DB::table('municipios')->limit(5)->get();
    foreach ($sample as $row) {
        $data = (array)$row;
        if (isset($data['id_departamento']) || isset($data['departamento_id']) || isset($data['department_id'])) {
            echo "Found department reference in municipios: " . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n";
        }
    }
} catch (Exception $e) {
    echo "Error checking relationships: " . $e->getMessage() . "\n";
}
