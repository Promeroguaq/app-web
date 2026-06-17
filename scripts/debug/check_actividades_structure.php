<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking actividades table structure...\n\n";

// Check actividades
try {
    $columns = DB::select("DESCRIBE actividades");
    echo "=== TABLE: actividades ===\n";
    foreach ($columns as $col) {
        echo "  {$col->Field} ({$col->Type})\n";
    }
    echo "\nSample data:\n";
    $sample = DB::table('actividades')->limit(3)->get();
    foreach ($sample as $row) {
        echo "  " . json_encode((array)$row, JSON_UNESCAPED_UNICODE) . "\n";
    }
} catch (Exception $e) {
    echo "Error checking actividades: " . $e->getMessage() . "\n";
}

echo "\n\n=== TABLE: tabla_gastronomia ===\n";
try {
    $columns = DB::select("DESCRIBE tabla_gastronomia");
    foreach ($columns as $col) {
        echo "  {$col->Field} ({$col->Type})\n";
    }
    echo "\nSample data:\n";
    $sample = DB::table('tabla_gastronomia')->limit(3)->get();
    foreach ($sample as $row) {
        echo "  " . json_encode((array)$row, JSON_UNESCAPED_UNICODE) . "\n";
    }
} catch (Exception $e) {
    echo "Error checking tabla_gastronomia: " . $e->getMessage() . "\n";
}

echo "\n\n=== TABLE: tabla_actividad_parque ===\n";
try {
    $columns = DB::select("DESCRIBE tabla_actividad_parque");
    foreach ($columns as $col) {
        echo "  {$col->Field} ({$col->Type})\n";
    }
    echo "\nSample data:\n";
    $sample = DB::table('tabla_actividad_parque')->limit(3)->get();
    foreach ($sample as $row) {
        echo "  " . json_encode((array)$row, JSON_UNESCAPED_UNICODE) . "\n";
    }
} catch (Exception $e) {
    echo "Error checking tabla_actividad_parque: " . $e->getMessage() . "\n";
}
