<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

try {
    echo "=== Probando la consulta exacta que falla ===\n\n";
    
    // Probar la consulta que está fallando según el error
    $actividades = \DB::table('tabla_actividad_parque')
        ->orderBy('NOMBRE_ACTIVIDAD_EN_PARQUE')
        ->get();
    
    echo "Consulta con NOMBRE_ACTIVIDAD_EN_PARQUE: SUCCESS\n";
    echo "Número de registros: " . $actividades->count() . "\n\n";
    
} catch (Exception $e) {
    echo "ERROR con NOMBRE_ACTIVIDAD_EN_PARQUE: " . $e->getMessage() . "\n\n";
    
    try {
        // Probar con el nombre que aparece en el error
        $actividades = \DB::table('tabla_actividad_parque')
            ->orderBy('NOMBRE_ACTIVIDAD')
            ->get();
        
        echo "Consulta con NOMBRE_ACTIVIDAD: SUCCESS\n";
        echo "Número de registros: " . $actividades->count() . "\n\n";
        
    } catch (Exception $e2) {
        echo "ERROR con NOMBRE_ACTIVIDAD: " . $e2->getMessage() . "\n\n";
    }
}

// Probar usando el modelo
try {
    echo "=== Probando con el modelo ActividadParque ===\n\n";
    
    $actividades = \App\Models\ActividadParque::orderBy('NOMBRE_ACTIVIDAD_EN_PARQUE')->get();
    
    echo "Modelo con NOMBRE_ACTIVIDAD_EN_PARQUE: SUCCESS\n";
    echo "Número de registros: " . $actividades->count() . "\n\n";
    
} catch (Exception $e) {
    echo "ERROR con modelo: " . $e->getMessage() . "\n\n";
}
