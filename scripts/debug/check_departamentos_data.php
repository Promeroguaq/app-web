<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECK TABLA_DEPARTAMENTOS ===\n";
$count = \DB::table('tabla_departamentos')->count();
echo "Count: $count\n";

if ($count > 0) {
    echo "\n=== ALL DEPARTAMENTOS ===\n";
    $all = \DB::table('tabla_departamentos')->orderBy('NOMBRE_DEPARTAMENTO')->get();
    foreach ($all as $row) {
        echo "ID: {$row->ID_DEPARTAMENTO}, Nombre: {$row->NOMBRE_DEPARTAMENTO}\n";
    }
    
    echo "\n=== CHECK FOR DUPLICATES BY NAME ===\n";
    $names = $all->pluck('NOMBRE_DEPARTAMENTO')->toArray();
    $uniqueNames = array_unique($names);
    echo "Total names: " . count($names) . "\n";
    echo "Unique names: " . count($uniqueNames) . "\n";
    
    if (count($names) !== count($uniqueNames)) {
        echo "DUPLICATES FOUND:\n";
        $duplicates = array_diff_assoc($names, $uniqueNames);
        print_r($duplicates);
    }
}
