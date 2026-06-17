<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check for duplicate departments
$duplicates = DB::select("
    SELECT NOMBRE_DEPARTAMENTO, COUNT(*) as count 
    FROM tabla_departamentos 
    GROUP BY NOMBRE_DEPARTAMENTO 
    HAVING COUNT(*) > 1 
    ORDER BY count DESC
");

echo "=== DEPARTAMENTOS DUPLICADOS ===\n";
if (empty($duplicates)) {
    echo "No se encontraron departamentos duplicados.\n";
} else {
    foreach ($duplicates as $dup) {
        echo "Departamento: '{$dup->NOMBRE_DEPARTAMENTO}' - Repetido: {$dup->count} veces\n";
    }
}

echo "\n=== TODOS LOS DEPARTAMENTOS (ordenados) ===\n";
$all_departments = DB::table('tabla_departamentos')
    ->orderBy('NOMBRE_DEPARTAMENTO')
    ->get();

foreach ($all_departments as $dept) {
    echo "ID: {$dept->ID_DEPARTAMENTO} - Nombre: '{$dept->NOMBRE_DEPARTAMENTO}'\n";
}

echo "\n=== TOTAL DEPARTAMENTOS ===\n";
echo "Total registros: " . count($all_departments) . "\n";

// Check unique departments
$unique_departments = DB::table('tabla_departamentos')
    ->distinct()
    ->pluck('NOMBRE_DEPARTAMENTO');
echo "Departamentos únicos: " . count($unique_departments) . "\n";
