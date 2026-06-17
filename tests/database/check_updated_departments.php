<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking updated departments query...\n\n";

// Test the exact query the controller is now using
$departamentos = DB::table('tabla_departamentos')
    ->select('ID_DEPARTAMENTO', 'NOMBRE_DEPARTAMENTO')
    ->orderBy('NOMBRE_DEPARTAMENTO')
    ->get();

echo "Updated departments count: " . count($departamentos) . "\n";

if (count($departamentos) > 0) {
    echo "Sample departments:\n";
    foreach ($departamentos->take(5) as $depto) {
        echo "- {$depto->NOMBRE_DEPARTAMENTO}\n";
    }
    
    // Check if Atlántico exists
    $atlantico = $departamentos->firstWhere('NOMBRE_DEPARTAMENTO', 'Atlántico');
    if ($atlantico) {
        echo "\nFound Atlántico: ID {$atlantico->ID_DEPARTAMENTO}\n";
    } else {
        echo "\nAtlántico not found in departments\n";
        
        // Look for similar names
        echo "Looking for similar names:\n";
        foreach ($departamentos as $depto) {
            if (stripos($depto->NOMBRE_DEPARTAMENTO, 'atl') !== false) {
                echo "- {$depto->NOMBRE_DEPARTAMENTO}\n";
            }
        }
    }
}

// Test the controller again
echo "\nTesting controller with updated query:\n";
$request = new \Illuminate\Http\Request([
    'categoria' => 'Actividad en parque',
    'departamento' => 'Atlántico'
]);

$controller = new \App\Http\Controllers\DestinosController();
$start = microtime(true);
try {
    $response = $controller->index($request);
    $time = microtime(true) - $start;
    echo "Controller completed in " . round($time * 1000, 2) . "ms\n";
    echo "Destinations returned: " . count($response['destinos']) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
