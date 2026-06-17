<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking department names...\n\n";

// Check exact department names in database
$departamentos = DB::table('departamentos')
    ->select('NOMBRE_DEPARTAMENTO')
    ->orderBy('NOMBRE_DEPARTAMENTO')
    ->get();

echo "Available departments:\n";
foreach ($departamentos as $depto) {
    $name = trim($depto->NOMBRE_DEPARTAMENTO);
    if (stripos($name, 'atl') !== false) {
        echo "- '$name' (MATCH)\n";
    } else {
        echo "- '$name'\n";
    }
}

echo "\nChecking 'Actividad en parque' destinations:\n";
$actividades = DB::table('tabla_actividad_parque')
    ->select('NOMBRE_ACTIVIDAD_EN_PARQUE', 'DEPARTAMENTO')
    ->limit(5)
    ->get();

foreach ($actividades as $actividad) {
    echo "- {$actividad->NOMBRE_ACTIVIDAD_EN_PARQUE} in " . ($actividad->DEPARTAMENTO ?? 'No department') . "\n";
}

// Check if there are any activities in Atlántico
echo "\nSearching for activities in any department containing 'atl':\n";
$activities = DB::table('tabla_actividad_parque')
    ->where('DEPARTAMENTO', 'LIKE', '%Atl%')
    ->get();

echo "Found " . count($activities) . " activities\n";
foreach ($activities as $activity) {
    echo "- {$activity->NOMBRE_ACTIVIDAD_EN_PARQUE} in " . ($activity->DEPARTAMENTO ?? 'No department') . "\n";
}
