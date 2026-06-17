<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== SIMULACIÓN EXACTA DEL CONTROLADOR ===\n";

try {
    // Obtener datos de la tabla tabla_departamentos
    $departamentos = \DB::table('tabla_departamentos')->orderBy('NOMBRE_DEPARTAMENTO')->limit(3)->get();
    
    // Obtener imágenes de ciudades capitales
    $imagenes_capitales = \DB::table('tabla_imagenes')
        ->where('NOMBRE_IMAGEN', 'like', '%capital%')
        ->orWhere('RUTA', 'like', '%/capital_cities/%')
        ->get();
    
    // Mapeo completo del controlador
    $capitales_map = [
        'Casanare' => ['Yopal'],
        'Amazonas' => ['Leticia'],
        'Antioquia' => ['Medellín']
    ];
    
    // Combinar departamentos con sus imágenes
    $departamentos_con_imagenes = $departamentos->map(function($depto) use ($imagenes_capitales, $capitales_map) {
        $depto_con_imagen = (object)[
            'id' => $depto->ID_DEPARTAMENTO,
            'nombre' => $depto->NOMBRE_DEPARTAMENTO,
            'descripcion' => $depto->DESCRIPCION ?? null,
            'imagen' => null
        ];
        
        // Buscar imagen relacionada (basado en nombres de ciudades capitales)
        foreach($imagenes_capitales as $imagen) {
            $depto_nombre = $depto->NOMBRE_DEPARTAMENTO;
            if (isset($capitales_map[$depto_nombre])) {
                foreach ($capitales_map[$depto_nombre] as $capital) {
                    // Buscar por nombre de imagen
                    if (stripos($imagen->NOMBRE_IMAGEN, $capital) !== false) {
                        $depto_con_imagen->imagen = $imagen->RUTA;
                        break 2;
                    }
                    // Buscar por ruta (sin espacios y en minúsculas)
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
        echo "  isset(imagen): " . (isset($depto->imagen) ? 'YES' : 'NO') . "\n";
        echo "  empty(imagen): " . (empty($depto->imagen) ? 'YES' : 'NO') . "\n";
        echo "  isset(imagen) && !empty(imagen): " . (isset($depto->imagen) && !empty($depto->imagen) ? 'YES' : 'NO') . "\n";
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
        echo "  isset(imagen) && !empty(imagen): " . (isset($item->imagen) && !empty($item->imagen) ? 'YES' : 'NO') . "\n";
        echo "\n";
    }
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
