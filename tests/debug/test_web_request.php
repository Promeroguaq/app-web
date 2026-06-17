<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing web request performance...\n\n";

// Simulate the actual web request
$request = \Illuminate\Http\Request::create('/destinos?categoria=Actividad%20en%20parque&departamento=Atl%C3%A1ntico');

$start = microtime(true);

try {
    $controller = new \App\Http\Controllers\DestinosController();
    $response = $controller->index($request);
    
    $totalTime = microtime(true) - $start;
    
    echo "Request completed successfully in " . round($totalTime * 1000, 2) . "ms\n";
    
    if (isset($response['destinos'])) {
        echo "Returned " . count($response['destinos']) . " destinations\n";
        echo "Categories: " . implode(', ', array_slice($response['categorias'], 0, 3)) . "...\n";
    }
    
} catch (Exception $e) {
    $totalTime = microtime(true) - $start;
    echo "Error after " . round($totalTime * 1000, 2) . "ms: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
