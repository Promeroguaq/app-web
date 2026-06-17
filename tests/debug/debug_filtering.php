<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging filtering logic...\n\n";

// Test without filters first
echo "Testing without filters:\n";
$request = new \Illuminate\Http\Request();

$start = microtime(true);
$controller = new \App\Http\Controllers\DestinosController();
$response = $controller->index($request);
$noFilterTime = microtime(true) - $start;

echo "No filters: " . count($response['destinos']) . " destinations in " . round($noFilterTime * 1000, 2) . "ms\n";

// Test with problematic filters
echo "\nTesting with filters (categoria=Actividad en parque, departamento=Atlántico):\n";
$request = new \Illuminate\Http\Request([
    'categoria' => 'Actividad en parque',
    'departamento' => 'Atlántico'
]);

$start = microtime(true);
$response = $controller->index($request);
$filterTime = microtime(true) - $start;

echo "With filters: " . count($response['destinos']) . " destinations in " . round($filterTime * 1000, 2) . "ms\n";

// Debug: Check what departments and categories actually exist
echo "\nChecking available departments:\n";
$departamentos = DB::table('departamentos')->pluck('NOMBRE_DEPARTAMENTO')->take(10)->all();
foreach ($departamentos as $depto) {
    echo "- '$depto'\n";
}

echo "\nChecking first few destinations:\n";
$firstDestinos = array_slice($response['destinos'], 0, 3);
foreach ($firstDestinos as $destino) {
    echo "- {$destino['categoria']} in {$destino['departamento']}\n";
}
