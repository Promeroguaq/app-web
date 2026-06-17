<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TABLA_ACTIVIDAD_PARQUE FULL STRUCTURE ===\n\n";

try {
    $columns = \DB::select("DESCRIBE tabla_actividad_parque");
    foreach ($columns as $col) {
        echo "- {$col->Field} ({$col->Type})\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== SAMPLE DATA WITH ALL COLUMNS (2 records) ===\n\n";

try {
    $data = \DB::table('tabla_actividad_parque')->limit(2)->get();
    foreach ($data as $row) {
        echo "ID_ACTIVIDAD: {$row->ID_ACTIVIDAD}\n";
        foreach ((array)$row as $key => $value) {
            if ($key !== 'ID_ACTIVIDAD') {
                $displayValue = is_null($value) ? 'NULL' : (strlen($value) > 80 ? substr($value, 0, 80) . '...' : $value);
                echo "  {$key}: {$displayValue}\n";
            }
        }
        echo "---\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== CHECK FOR RECOMMENDATION COLUMNS ===\n\n";

try {
    $columns = \DB::select("DESCRIBE tabla_actividad_parque");
    $recommendationColumns = [];
    foreach ($columns as $col) {
        $fieldName = strtolower($col->Field);
        if (strpos($fieldName, 'recom') !== false || 
            strpos($fieldName, 'observ') !== false ||
            strpos($fieldName, 'requis') !== false ||
            strpos($fieldName, 'indic') !== false ||
            strpos($fieldName, 'consej') !== false ||
            strpos($fieldName, 'tip') !== false ||
            strpos($fieldName, 'que_llevar') !== false ||
            strpos($fieldName, 'seguridad') !== false) {
            $recommendationColumns[] = $col->Field;
        }
    }
    
    if (!empty($recommendationColumns)) {
        echo "Found recommendation-related columns:\n";
        foreach ($recommendationColumns as $col) {
            echo "  - {$col}\n";
        }
    } else {
        echo "No recommendation-related columns found.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== CHECK tabla_imagenes FOR ACTIVITY IMAGES ===\n\n";

try {
    $imagenes = \DB::table('tabla_imagenes')
        ->where('RUTA', 'like', '%actividades_en_parques%')
        ->limit(10)
        ->get();
    
    echo "Found {$imagenes->count()} images in actividades_en_parques:\n";
    foreach ($imagenes as $img) {
        echo "  - NOMBRE_IMAGEN: {$img->NOMBRE_IMAGEN}\n";
        echo "    RUTA: {$img->RUTA}\n";
        echo "---\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
