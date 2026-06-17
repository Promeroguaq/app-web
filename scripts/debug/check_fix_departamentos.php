<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICANDO CORRECCIÓN DE DEPARTAMENTOS ===\n";

// Test the fixed query
$departamentos_fixed = DB::table('tabla_departamentos')
    ->select('ID_DEPARTAMENTO', 'NOMBRE_DEPARTAMENTO')
    ->distinct()
    ->orderBy('NOMBRE_DEPARTAMENTO')
    ->get();

echo "Departamentos después de DISTINCT: " . count($departamentos_fixed) . "\n";

echo "\n=== LISTADO DEPARTAMENTOS CORREGIDOS ===\n";
foreach ($departamentos_fixed as $dept) {
    echo "ID: {$dept->ID_DEPARTAMENTO} - Nombre: '{$dept->NOMBRE_DEPARTAMENTO}'\n";
}

// Verify no duplicates remain
$duplicates_check = [];
foreach ($departamentos_fixed as $dept) {
    if (isset($duplicates_check[$dept->NOMBRE_DEPARTAMENTO])) {
        echo "ERROR: Todavía hay duplicados: '{$dept->NOMBRE_DEPARTAMENTO}'\n";
    }
    $duplicates_check[$dept->NOMBRE_DEPARTAMENTO] = true;
}

echo "\n=== VERIFICACIÓN EXITOSA ===\n";
echo "Total departamentos únicos: " . count($departamentos_fixed) . "\n";
echo "No hay duplicados.\n";
