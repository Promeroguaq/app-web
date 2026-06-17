<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TABLA_ACTIVIDAD_PARQUE STRUCTURE ===\n\n";

try {
    $columns = \DB::select("DESCRIBE tabla_actividad_parque");
    foreach ($columns as $col) {
        echo "- {$col->Field} ({$col->Type})\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== SAMPLE DATA (3 records) ===\n\n";

try {
    $data = \DB::table('tabla_actividad_parque')->limit(3)->get();
    foreach ($data as $row) {
        echo "ID_ACTIVIDAD: {$row->ID_ACTIVIDAD}\n";
        foreach ((array)$row as $key => $value) {
            if ($key !== 'ID_ACTIVIDAD') {
                echo "  {$key}: " . (strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value) . "\n";
            }
        }
        echo "---\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== TOTAL COUNT ===\n\n";

try {
    $count = \DB::table('tabla_actividad_parque')->count();
    echo "Total records: {$count}\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
