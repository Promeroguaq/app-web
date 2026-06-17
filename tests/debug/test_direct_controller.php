<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing controller directly with debugging...\n\n";

// Test the exact failing request
$request = new \Illuminate\Http\Request([
    'categoria' => 'Actividad en parque',
    'departamento' => 'Atlántico'
]);

$controller = new \App\Http\Controllers\DestinosController();

// Let me manually step through what the controller does
echo "Step 1: Getting departments\n";
$departamentos = DB::table('departamentos')
    ->select('id_departamento as ID_DEPARTAMENTO', 'nombre_departamento as NOMBRE_DEPARTAMENTO')
    ->orderBy('nombre_departamento')
    ->get();
echo "Departments count: " . count($departamentos) . "\n";

echo "\nStep 2: Getting municipalities\n";
$municipios = DB::table('tabla_municipios')
    ->select('ID_MUNICIPIOS', 'NOMBRE_MUNICIPIOS', 'ID_LOCALITIES', 'ID_DEPARTAMENTO')
    ->orderBy('NOMBRE_MUNICIPIOS')
    ->get();
echo "Municipalities count: " . count($municipios) . "\n";

echo "\nStep 3: Calling controller index method\n";
$start = microtime(true);
try {
    $response = $controller->index($request);
    $time = microtime(true) - $start;
    echo "Controller completed successfully in " . round($time * 1000, 2) . "ms\n";
    echo "Destinations returned: " . count($response['destinos']) . "\n";
    
    if (count($response['destinos']) > 0) {
        echo "Sample destinations:\n";
        foreach (array_slice($response['destinos'], 0, 3) as $destino) {
            echo "- {$destino['nombre']} ({$destino['categoria']})\n";
        }
    }
} catch (Exception $e) {
    $time = microtime(true) - $start;
    echo "Controller failed after " . round($time * 1000, 2) . "ms: " . $e->getMessage() . "\n";
}
