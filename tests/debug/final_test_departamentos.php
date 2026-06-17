<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST FINAL - CONTROLADOR COMPLETO ===\n";

// Obtener los primeros 5 departamentos
$departamentos = DB::table('tabla_departamentos')->orderBy('NOMBRE_DEPARTAMENTO')->limit(5)->get();

// Obtener imágenes de ciudades capitales
$imagenes_capitales = DB::table('tabla_imagenes')
    ->where('NOMBRE_IMAGEN', 'like', '%capital%')
    ->orWhere('RUTA', 'like', '%/capital_cities/%')
    ->get();

// Mapeo completo del controlador
$capitales_map = [
    'Casanare' => ['Yopal'],
    'Amazonas' => ['Leticia'],
    'Antioquia' => ['Medellín'],
    'Atlántico' => ['Barranquilla'],
    'Valle del Cauca' => ['Cali']
];

// Combinar departamentos con sus imágenes
$departamentos_con_imagenes = $departamentos->map(function($depto) use ($imagenes_capitales, $capitales_map) {
    $depto_con_imagen = (object)[
        'id' => $depto->ID_DEPARTAMENTO,
        'nombre' => $depto->NOMBRE_DEPARTAMENTO,
        'descripcion' => $depto->DESCRIPCION ?? null,
        'imagen' => null
    ];
    
    $depto_nombre = $depto->NOMBRE_DEPARTAMENTO;
    echo "Procesando: $depto_nombre\n";
    
    if (isset($capitales_map[$depto_nombre])) {
        foreach ($capitales_map[$depto_nombre] as $capital) {
            foreach($imagenes_capitales as $imagen) {
                // Buscar por nombre de imagen
                if (stripos($imagen->NOMBRE_IMAGEN, $capital) !== false) {
                    $depto_con_imagen->imagen = $imagen->RUTA;
                    echo "  ✅ Imagen encontrada: $capital -> " . $imagen->RUTA . "\n";
                    break 2;
                }
                // Buscar por ruta
                $capital_clean = strtolower(str_replace(' ', '', $capital));
                if (stripos($imagen->RUTA, $capital_clean) !== false) {
                    $depto_con_imagen->imagen = $imagen->RUTA;
                    echo "  ✅ Imagen encontrada por ruta: $capital -> " . $imagen->RUTA . "\n";
                    break 2;
                }
            }
        }
    } else {
        echo "  ❌ No está en el mapeo\n";
    }
    
    if (!$depto_con_imagen->imagen) {
        echo "  ❌ No se encontró imagen\n";
    }
    
    echo "\n";
    return $depto_con_imagen;
});

echo "=== RESULTADO FINAL ===\n";
foreach($departamentos_con_imagenes as $depto) {
    echo $depto->nombre . ": " . ($depto->imagen ? "✅ TIENE IMAGEN" : "❌ SIN IMAGEN") . "\n";
}
