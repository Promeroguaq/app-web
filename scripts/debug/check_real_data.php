<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICANDO DATOS REALES EN TABLAS ===\n";

// Check which tables have real data
$tables = [
    'tabla_actividad_parque' => 'ID_ACTIVIDAD',
    'tabla_capitales' => 'ID_CAPITAL', 
    'tabla_ciclismo' => 'ID_CICLISMO',
    'tabla_deporte_aventura' => 'ID_DEPORTES',
    'tabla_desierto_laguna' => 'ID_DESIERTO',
    'tabla_iglesias' => 'ID_IGLESIA',
    'tabla_islas' => 'ID_ISLA',
    'tabla_museos' => 'COL 1',
    'tabla_parque_tematicos' => 'ID_PARQUES',
    'tabla_playas' => 'ID_PLAYA',
    'tabla_reservas' => 'ID_RESERVAS',
    'tabla_termales' => 'ID_TERMALES'
];

foreach ($tables as $table => $idField) {
    try {
        $count = DB::table($table)->count();
        echo "Tabla: $table - Registros: $count\n";
        
        if ($count > 0) {
            $sample = DB::table($table)->limit(2)->get();
            foreach ($sample as $record) {
                echo "  - ID: {$record->$idField}\n";
                if (isset($record->DESCRIPCION)) {
                    echo "  - Descripción: " . substr($record->DESCRIPCION, 0, 50) . "...\n";
                }
            }
        }
        echo "\n";
    } catch (\Exception $e) {
        echo "Tabla: $table - ERROR: " . $e->getMessage() . "\n\n";
    }
}

echo "=== VERIFICANDO TABLAS DE UBICACIÓN ===\n";
try {
    $municipios = DB::table('tabla_municipios')->count();
    $departamentos = DB::table('tabla_departamentos')->count();
    echo "Municipios: $municipios\n";
    echo "Departamentos: $departamentos\n";
} catch (\Exception $e) {
    echo "Error en tablas de ubicación: " . $e->getMessage() . "\n";
}

echo "\n=== VERIFICANDO IMÁGENES ===\n";
try {
    $imagenes = DB::table('tabla_imagenes')->count();
    echo "Imágenes: $imagenes\n";
} catch (\Exception $e) {
    echo "Error en tabla de imágenes: " . $e->getMessage() . "\n";
}
