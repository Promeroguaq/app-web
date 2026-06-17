<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking featured municipalities in database...\n\n";

$featured = [
    ['name' => 'Cartagena', 'slug' => 'cartagena', 'department' => 'bolivar'],
    ['name' => 'Santa Marta', 'slug' => 'santa-marta', 'department' => 'magdalena'],
    ['name' => 'Medellín', 'slug' => 'medellin', 'department' => 'antioquia'],
    ['name' => 'Bogotá', 'slug' => 'bogota', 'department' => 'cundinamarca'],
    ['name' => 'Villa de Leyva', 'slug' => 'villa-de-leyva', 'department' => 'boyaca'],
    ['name' => 'Nuquí', 'slug' => 'nuqui', 'department' => 'choco'],
];

foreach ($featured as $item) {
    $municipio = DB::table('tabla_municipios')
        ->where('NOMBRE_MUNICIPIOS', 'like', '%' . $item['name'] . '%')
        ->first();
    
    if ($municipio) {
        echo "✓ Found: " . $item['name'] . " (ID: " . $municipio->ID_MUNICIPIOS . ")\n";
        echo "  DB Name: " . $municipio->NOMBRE_MUNICIPIOS . "\n";
        echo "  Department ID: " . $municipio->ID_DEPARTAMENTO . "\n";
    } else {
        echo "✗ NOT FOUND: " . $item['name'] . "\n";
    }
    echo "\n";
}
