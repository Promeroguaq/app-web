<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging filtering step by step...\n\n";

// Simulate the exact request
$request = new \Illuminate\Http\Request([
    'categoria' => 'Actividad en parque',
    'departamento' => 'Atlántico'
]);

$controller = new \App\Http\Controllers\DestinosController();

// Step 1: Get departments and municipalities
echo "Step 1: Getting departments and municipalities\n";
$departamentos = DB::table('departamentos')
    ->select('id_departamento as ID_DEPARTAMENTO', 'nombre_departamento as NOMBRE_DEPARTAMENTO')
    ->orderBy('nombre_departamento')
    ->get();
    
$municipios = DB::table('tabla_municipios')
    ->select('ID_MUNICIPIOS', 'NOMBRE_MUNICIPIOS', 'ID_LOCALITIES', 'ID_DEPARTAMENTO')
    ->orderBy('NOMBRE_MUNICIPIOS')
    ->get();

echo "Departments count: " . count($departamentos) . "\n";
echo "Municipalities count: " . count($municipios) . "\n";

// Step 2: Get all destinations
echo "\nStep 2: Getting all destinations\n";
$destinos = collect($controller->obtenerDestinosDesdeBaseDeDatos());
echo "Total destinations before filtering: " . count($destinos) . "\n";

// Step 3: Apply category filter
echo "\nStep 3: Applying category filter\n";
if ($request->filled('categoria') && $request->categoria !== 'Todas las categorías') {
    $destinos = $destinos->filter(function ($destino) use ($request) {
        return $destino['categoria'] === $request->categoria;
    });
}
echo "Destinations after category filter: " . count($destinos) . "\n";

// Step 4: Apply department filter
echo "\nStep 4: Applying department filter\n";
if ($request->filled('departamento') && $request->departamento !== 'Todos los departamentos') {
    echo "Department requested: '{$request->departamento}'\n";
    echo "Departments table empty: " . (count($departamentos) === 0 ? 'YES' : 'NO') . "\n";
    
    // If departments table is empty, show all destinations for the category instead of filtering by department
    if (count($departamentos) === 0) {
        echo "Using fallback - not filtering by department\n";
        // Don't filter by department since we don't have department data
        // Just keep the category filtering that was applied above
    } else {
        echo "Using normal department filtering\n";
        // Normal department filtering
        $destinos = $destinos->filter(function ($destino) use ($request) {
            return trim($destino['departamento']) === trim($request->departamento);
        });
    }
}
echo "Destinations after department filter: " . count($destinos) . "\n";

// Step 5: Show a few sample destinations
echo "\nStep 5: Sample destinations after filtering\n";
foreach ($destinos->take(3) as $destino) {
    echo "- {$destino['nombre']} ({$destino['categoria']}) in {$destino['departamento']}\n";
}
