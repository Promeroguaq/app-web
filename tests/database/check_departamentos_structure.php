<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking departamentos table structure...\n\n";

// Check if departamentos table exists and its structure
try {
    $columns = DB::select("SHOW COLUMNS FROM departamentos");
    echo "departamentos table columns:\n";
    foreach ($columns as $column) {
        echo "- {$column->Field}\n";
    }
    
    echo "\nSample data from departamentos:\n";
    $sample = DB::table('departamentos')->limit(5)->get();
    foreach ($sample as $row) {
        $data = (array)$row;
        echo "- " . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n";
    }
} catch (Exception $e) {
    echo "Error accessing departamentos table: " . $e->getMessage() . "\n";
    
    // Check if tabla_departamentos exists instead
    try {
        echo "\nChecking tabla_departamentos table:\n";
        $columns = DB::select("SHOW COLUMNS FROM tabla_departamentos");
        foreach ($columns as $column) {
            echo "- {$column->Field}\n";
        }
        
        $sample = DB::table('tabla_departamentos')->limit(5)->get();
        echo "\nSample data from tabla_departamentos:\n";
        foreach ($sample as $row) {
            $data = (array)$row;
            echo "- " . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n";
        }
    } catch (Exception $e2) {
        echo "No departments table found: " . $e2->getMessage() . "\n";
    }
}
