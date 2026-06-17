<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking Atlántico department mapping...\n\n";

// Find Atlántico department
$atlantico = DB::table('departamentos')
    ->where('NOMBRE_DEPARTAMENTO', 'LIKE', '%Atl%')
    ->first();

if ($atlantico) {
    echo "Found department: '{$atlantico->NOMBRE_DEPARTAMENTO}' (ID: {$atlantico->ID_DEPARTAMENTO})\n";
    
    // Find municipalities in Atlántico
    $municipios = DB::table('municipios')
        ->where('ID_DEPARTAMENTO', $atlantico->ID_DEPARTAMENTO)
        ->get();
    
    echo "Municipios in Atlántico:\n";
    foreach ($municipios as $municipio) {
        echo "- {$municipio->NOMBRE_MUNICIPIOS} (ID_MUNICIPIOS: {$municipio->ID_MUNICIPIOS}, ID_LOCALITIES: " . ($municipio->ID_LOCALITIES ?? 'NULL') . ")\n";
    }
    
    // Check activities in these municipalities
    $localityIds = $municipios->pluck('ID_LOCALITIES')->filter();
    echo "\nChecking activities in these localities:\n";
    
    foreach ($localityIds as $localityId) {
        $activities = DB::table('tabla_actividad_parque')
            ->where('ID_LOCALITITES', $localityId)
            ->get();
            
        if (count($activities) > 0) {
            echo "- Locality $localityId: " . count($activities) . " activities\n";
            foreach ($activities as $activity) {
                echo "  * {$activity->NOMBRE_ACTIVIDAD_EN_PARQUE}\n";
            }
        }
    }
} else {
    echo "Atlántico department not found\n";
    
    // Show all departments
    echo "\nAll departments:\n";
    $allDepts = DB::table('departamentos')->get();
    foreach ($allDepts as $dept) {
        echo "- {$dept->NOMBRE_DEPARTAMENTO}\n";
    }
}
