<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Final debugging of filtering logic...\n\n";

// Test without filters first
echo "Testing without filters:\n";
$request = new \Illuminate\Http\Request();

$start = microtime(true);
$controller = new \App\Http\Controllers\DestinosController();
$response = $controller->index($request);
$noFilterTime = microtime(true) - $start;

echo "No filters: " . count($response['destinos']) . " destinations in " . round($noFilterTime * 1000, 2) . "ms\n";

if (count($response['destinos']) > 0) {
    echo "First few destinations:\n";
    foreach (array_slice($response['destinos'], 0, 3) as $destino) {
        echo "- {$destino['categoria']} in {$destino['departamento']}, {$destino['municipio']}\n";
    }
}

echo "\nAvailable departments:\n";
foreach ($response['departamentos'] as $depto) {
    echo "- '{$depto->NOMBRE_DEPARTAMENTO}'\n";
}

echo "\nAvailable categories:\n";
foreach (array_slice($response['categorias'], 0, 5) as $cat) {
    echo "- '$cat'\n";
}

// Test with the problematic filters
echo "\nTesting with filters (categoria=Actividad en parque, departamento=Atlántico):\n";
$request = new \Illuminate\Http\Request([
    'categoria' => 'Actividad en parque',
    'departamento' => 'Atlántico'
]);

$start = microtime(true);
$response = $controller->index($request);
$filterTime = microtime(true) - $start;

echo "With filters: " . count($response['destinos']) . " destinations in " . round($filterTime * 1000, 2) . "ms\n";

// Test with just category filter
echo "\nTesting with only category filter (Actividad en parque):\n";
$request = new \Illuminate\Http\Request([
    'categoria' => 'Actividad en parque'
]);

$start = microtime(true);
$response = $controller->index($request);
$catOnlyTime = microtime(true) - $start;

echo "Category only: " . count($response['destinos']) . " destinations in " . round($catOnlyTime * 1000, 2) . "ms\n";
