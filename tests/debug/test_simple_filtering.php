<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing simple filtering logic...\n\n";

// Test just category filtering without department
echo "Test 1: Only category filter (Actividad en parque)\n";
$request1 = new \Illuminate\Http\Request([
    'categoria' => 'Actividad en parque'
]);

$start = microtime(true);
$controller = new \App\Http\Controllers\DestinosController();
$response1 = $controller->index($request1);
$time1 = microtime(true) - $start;

echo "Results: " . count($response1['destinos']) . " destinations in " . round($time1 * 1000, 2) . "ms\n";

if (count($response1['destinos']) > 0) {
    echo "Sample destinations:\n";
    foreach (array_slice($response1['destinos'], 0, 3) as $destino) {
        echo "- {$destino['nombre']} ({$destino['categoria']})\n";
    }
}

// Test category + department filter
echo "\nTest 2: Category + department filter\n";
$request2 = new \Illuminate\Http\Request([
    'categoria' => 'Actividad en parque',
    'departamento' => 'Atlántico'
]);

$start = microtime(true);
$response2 = $controller->index($request2);
$time2 = microtime(true) - $start;

echo "Results: " . count($response2['destinos']) . " destinations in " . round($time2 * 1000, 2) . "ms\n";

// Test with no filters
echo "\nTest 3: No filters\n";
$request3 = new \Illuminate\Http\Request([]);

$start = microtime(true);
$response3 = $controller->index($request3);
$time3 = microtime(true) - $start;

echo "Results: " . count($response3['destinos']) . " destinations in " . round($time3 * 1000, 2) . "ms\n";
