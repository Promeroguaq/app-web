<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging filtering in detail...\n\n";

// Simulate the exact request
$request = new \Illuminate\Http\Request([
    'categoria' => 'Actividad en parque',
    'departamento' => 'Atlántico'
]);

// Get departments and municipalities
$departamentos = DB::table('departamentos')
    ->select('id_departamento as ID_DEPARTAMENTO', 'nombre_departamento as NOMBRE_DEPARTAMENTO')
    ->orderBy('nombre_departamento')
    ->get();
    
$municipios = DB::table('tabla_municipios')
    ->select('ID_MUNICIPIOS', 'NOMBRE_MUNICIPIOS', 'ID_LOCALITIES', 'ID_DEPARTAMENTO')
    ->orderBy('NOMBRE_MUNICIPIOS')
    ->get();

echo "Departments count: " . count($departamentos) . "\n";
echo "Request departamento: '{$request->departamento}'\n";
echo "Request filled: " . ($request->filled('departamento') ? 'YES' : 'NO') . "\n";
echo "Not all departments: " . ($request->departamento !== 'Todos los departamentos' ? 'YES' : 'NO') . "\n";

// Get all destinations
$controller = new \App\Http\Controllers\DestinosController();
$destinos = collect($controller->obtenerDestinosDesdeBaseDeDatos());

echo "\nBefore filtering: " . count($destinos) . " destinations\n";

// Apply category filter
if ($request->filled('categoria') && $request->categoria !== 'Todas las categorías') {
    $destinos = $destinos->filter(function ($destino) use ($request) {
        return $destino['categoria'] === $request->categoria;
    });
}
echo "After category filter: " . count($destinos) . " destinations\n";

// Apply department filter
if ($request->filled('departamento') && $request->departamento !== 'Todos los departamentos') {
    echo "\nApplying department filter...\n";
    echo "Departments table empty: " . (count($departamentos) === 0 ? 'YES' : 'NO') . "\n";
    
    if (count($departamentos) === 0) {
        echo "Using fallback - should NOT filter destinations\n";
        // Don't filter by department since we don't have department data
        // Just keep the category filtering that was applied above
        $municipiosFiltro = $municipios->pluck('NOMBRE_MUNICIPIOS')->values()->all();
        echo "Municipios filter count: " . count($municipiosFiltro) . "\n";
    } else {
        echo "Using normal department filtering\n";
        // Normal department filtering
        $destinos = $destinos->filter(function ($destino) use ($request) {
            return trim($destino['departamento']) === trim($request->departamento);
        });
        $municipiosFiltro = $this->obtenerMunicipiosPorDepartamento($request->departamento);
    }
} else {
    $municipiosFiltro = $municipios->pluck('NOMBRE_MUNICIPIOS')->values()->all();
}

echo "After department filter: " . count($destinos) . " destinations\n";

// Show sample destinations
echo "\nSample destinations:\n";
foreach ($destinos->take(3) as $destino) {
    echo "- {$destino['nombre']} ({$destino['categoria']}) in {$destino['departamento']}\n";
}
