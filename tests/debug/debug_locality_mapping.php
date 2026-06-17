<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging locality mapping for activities...\n\n";

// Check what locality IDs activities are using
echo "Activities and their locality IDs:\n";
$activities = DB::table('tabla_actividad_parque')
    ->select('NOMBRE_ACTIVIDAD_EN_PARQUE', 'ID_LOCALITITES')
    ->limit(10)
    ->get();

foreach ($activities as $activity) {
    echo "- {$activity->NOMBRE_ACTIVIDAD_EN_PARQUE} (Locality: {$activity->ID_LOCALITITES})\n";
}

// Check what departments these localities map to
echo "\nMapping localities to departments:\n";
$localityIds = $activities->pluck('ID_LOCALITITES')->unique();

foreach ($localityIds as $localityId) {
    $municipio = DB::table('tabla_municipios')
        ->select('NOMBRE_MUNICIPIOS', 'ID_DEPARTAMENTO')
        ->where('ID_LOCALITIES', $localityId)
        ->first();
        
    if ($municipio) {
        $depto = DB::table('departamentos')
            ->select('nombre_departamento')
            ->where('id_departamento', $municipio->ID_DEPARTAMENTO)
            ->first();
            
        echo "- Locality $localityId: {$municipio->NOMBRE_MUNICIPIOS} in " . ($depto->nombre_departamento ?? 'Unknown') . "\n";
    } else {
        echo "- Locality $localityId: No municipality found\n";
    }
}

// Check specifically for Atlántico department
echo "\nChecking Atlántico department municipalities:\n";
$atlantico = DB::table('departamentos')
    ->where('nombre_departamento', 'Atlántico')
    ->first();

if ($atlantico) {
    $municipios = DB::table('tabla_municipios')
        ->select('NOMBRE_MUNICIPIOS', 'ID_LOCALITIES')
        ->where('ID_DEPARTAMENTO', $atlantico->id_departamento)
        ->get();
        
    echo "Atlántico municipalities:\n";
    foreach ($municipios as $municipio) {
        echo "- {$municipio->NOMBRE_MUNICIPIOS} (Locality: {$municipio->ID_LOCALITIES})\n";
    }
} else {
    echo "Atlántico department not found\n";
}
