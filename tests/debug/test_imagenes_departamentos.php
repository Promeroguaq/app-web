<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== PROBANDO LÓGICA DE IMÁGENES ===\n";

// Obtener departamentos
$departamentos = DB::table('tabla_departamentos')->limit(5)->get();

// Obtener imágenes de capitales
$imagenes_capitales = DB::table('tabla_imagenes')
    ->where('NOMBRE_IMAGEN', 'like', '%capital%')
    ->orWhere('RUTA', 'like', '%/capital_cities/%')
    ->get();

foreach($departamentos as $depto) {
    echo "\n--- DEPARTAMENTO: " . $depto->NOMBRE_DEPARTAMENTO . " ---\n";
    
    $imagen_encontrada = null;
    
    // Mapeo simplificado para prueba
    $capitales_map = [
        'Atlántico' => ['Barranquilla'],
        'Valle del Cauca' => ['Cali'],
        'Bolívar' => ['Cartagena'],
        'Caldas' => ['Manizales'],
        'Antioquia' => ['Medellín']
    ];
    
    $depto_nombre = $depto->NOMBRE_DEPARTAMENTO;
    if (isset($capitales_map[$depto_nombre])) {
        foreach ($capitales_map[$depto_nombre] as $capital) {
            foreach($imagenes_capitales as $imagen) {
                // Buscar por nombre de imagen
                if (stripos($imagen->NOMBRE_IMAGEN, $capital) !== false) {
                    $imagen_encontrada = $imagen->RUTA;
                    echo "  Imagen encontrada por nombre: " . $imagen->NOMBRE_IMAGEN . " -> " . $imagen->RUTA . "\n";
                    break 2;
                }
                // Buscar por ruta
                $capital_clean = strtolower(str_replace(' ', '', $capital));
                if (stripos($imagen->RUTA, $capital_clean) !== false) {
                    $imagen_encontrada = $imagen->RUTA;
                    echo "  Imagen encontrada por ruta: " . $imagen->NOMBRE_IMAGEN . " -> " . $imagen->RUTA . "\n";
                    break 2;
                }
            }
        }
    }
    
    if (!$imagen_encontrada) {
        echo "  No se encontró imagen\n";
    }
}
