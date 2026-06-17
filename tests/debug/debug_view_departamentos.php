<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== SIMULANDO CONTROLADOR DE DEPARTAMENTOS ===\n";

// Obtener datos de la tabla tabla_departamentos
$departamentos = DB::table('tabla_departamentos')->orderBy('NOMBRE_DEPARTAMENTO')->limit(3)->get();

// Obtener imágenes de ciudades capitales
$imagenes_capitales = DB::table('tabla_imagenes')
    ->where('NOMBRE_IMAGEN', 'like', '%capital%')
    ->orWhere('RUTA', 'like', '%/capital_cities/%')
    ->get();

// Combinar departamentos con sus imágenes
$departamentos_con_imagenes = $departamentos->map(function($depto) use ($imagenes_capitales) {
    $depto_con_imagen = (object)[
        'id' => $depto->ID_DEPARTAMENTO,
        'nombre' => $depto->NOMBRE_DEPARTAMENTO,
        'descripcion' => $depto->DESCRIPCION ?? null,
        'imagen' => null
    ];
    
    // Mapeo simplificado para prueba
    $capitales_map = [
        'Casanare' => ['Yopal'],
        'Amazonas' => ['Leticia'],
        'Antioquia' => ['Medellín']
    ];
    
    $depto_nombre = $depto->NOMBRE_DEPARTAMENTO;
    if (isset($capitales_map[$depto_nombre])) {
        foreach ($capitales_map[$depto_nombre] as $capital) {
            foreach($imagenes_capitales as $imagen) {
                if (stripos($imagen->NOMBRE_IMAGEN, $capital) !== false) {
                    $depto_con_imagen->imagen = $imagen->RUTA;
                    break 2;
                }
                $capital_clean = strtolower(str_replace(' ', '', $capital));
                if (stripos($imagen->RUTA, $capital_clean) !== false) {
                    $depto_con_imagen->imagen = $imagen->RUTA;
                    break 2;
                }
            }
        }
    }
    
    return $depto_con_imagen;
});

echo "=== DATOS QUE LLEGARÍAN A LA VISTA ===\n";
foreach($departamentos_con_imagenes as $depto) {
    echo "Departamento: " . $depto->nombre . "\n";
    echo "  ID: " . $depto->id . "\n";
    echo "  Imagen: " . ($depto->imagen ? $depto->imagen : 'NULL') . "\n";
    echo "  ¿Tiene imagen?: " . (isset($depto->imagen) ? 'YES' : 'NO') . "\n";
    echo "  ¿Imagen no nula?: " . ($depto->imagen != null ? 'YES' : 'NO') . "\n";
    echo "  ¿Imagen no vacía?: " . (!empty($depto->imagen) ? 'YES' : 'NO') . "\n";
    echo "\n";
}

// Simular el mapeo de la vista
echo "=== DATOS DESPUÉS DE MAPEO DE VISTA ===\n";
$items = $departamentos_con_imagenes->map(function($item) {
    return (object)[
        'id' => $item->id,
        'nombre' => $item->nombre,
        'descripcion' => $item->descripcion,
        'imagen' => $item->imagen ?? null
    ];
});

foreach($items as $item) {
    echo "Item: " . $item->nombre . "\n";
    echo "  Imagen: " . ($item->imagen ? $item->imagen : 'NULL') . "\n";
    echo "  isset(imagen): " . (isset($item->imagen) ? 'YES' : 'NO') . "\n";
    echo "\n";
}
