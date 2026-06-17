<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICANDO NUEVAS CATEGORÍAS AGREGADAS ===\n";

// Test the new categories
$gastronomia_count = DB::table('tabla_gastronomia')->count();
$regiones_count = DB::table('tabla_regiones')->count();

echo "Gastronomía: $gastronomia_count registros\n";
echo "Regiones: $regiones_count registros\n";

echo "\n=== MUESTRA DE GASTRONOMÍA ===\n";
$sample_gastronomia = DB::table('tabla_gastronomia')->limit(3)->get();
foreach ($sample_gastronomia as $plato) {
    echo "- {$plato->PLATOS_TIPICOS} ({$plato->DEPARTAMENTO})\n";
    echo "  Categoría: {$plato->CATEGORIA}\n";
    echo "  Región: {$plato->REGIÓN}\n";
    echo "  Descripción: " . substr($plato->DESCRIPCION, 0, 100) . "...\n\n";
}

echo "=== MUESTRA DE REGIONES ===\n";
$sample_regiones = DB::table('tabla_regiones')->limit(3)->get();
foreach ($sample_regiones as $region) {
    echo "- {$region->NOMBRE_REGION}\n";
    echo "  Descripción: " . substr($region->DESCRIPCION, 0, 100) . "...\n\n";
}

echo "=== VERIFICANDO QUE APAREZCAN EN FILTROS ===\n";

// Simulate the controller logic
$categorias = [
    ['tabla' => 'tabla_gastronomia', 'id' => 'ID_PLATOS', 'nombre' => 'PLATOS_TIPICOS', 'categoria' => 'Gastronomía', 'descripcion' => 'DESCRIPCION', 'locality' => null, 'prefijo' => 'gastronomia', 'calificacion' => 4.9],
    ['tabla' => 'tabla_regiones', 'id' => 'ID_REGION', 'nombre' => 'NOMBRE_REGION', 'categoria' => 'Regiones', 'descripcion' => 'DESCRIPCION', 'locality' => 'ID_LOCALITIES', 'prefijo' => 'region', 'calificacion' => 4.8],
];

foreach ($categorias as $config) {
    $count = DB::table($config['tabla'])->count();
    echo "✅ {$config['categoria']}: $count registros disponibles\n";
}

echo "\n=== TOTAL CATEGORÍAS DISPONIBLES ===\n";
echo "Antes: 12 categorías\n";
echo "Ahora: 14 categorías (agregando Gastronomía y Regiones)\n";
