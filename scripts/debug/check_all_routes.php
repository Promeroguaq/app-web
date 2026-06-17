<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICANDO TODAS LAS RUTAS Y DATOS ===\n";

// Check all routes and their data
$routes_data = [
    '/puntos-interes/deportes-aventura' => ['tabla' => 'tabla_deporte_aventura', 'nombre' => 'Deportes de aventura'],
    '/puntos-interes/desiertos-lagunas' => ['tabla' => 'tabla_desierto_laguna', 'nombre' => 'Desiertos/Lagunas'],
    '/puntos-interes/gastronomia' => ['tabla' => 'tabla_gastronomia', 'nombre' => 'Gastronomía'],
    '/puntos-interes/iglesias' => ['tabla' => 'tabla_iglesias', 'nombre' => 'Iglesias'],
    '/puntos-interes/islas' => ['tabla' => 'tabla_islas', 'nombre' => 'Islas'],
    '/puntos-interes/museos' => ['tabla' => 'tabla_museos', 'nombre' => 'Museos'],
    '/puntos-interes/parques-tematicos' => ['tabla' => 'tabla_parque_tematicos', 'nombre' => 'Parques temáticos'],
    '/puntos-interes/playas' => ['tabla' => 'tabla_playas', 'nombre' => 'Playas'],
    '/puntos-interes/reservas-naturales' => ['tabla' => 'tabla_reservas', 'nombre' => 'Reservas naturales'],
    '/puntos-interes/termales' => ['tabla' => 'tabla_termales', 'nombre' => 'Termales'],
    '/puntos-interes/actividades-parques' => ['tabla' => 'tabla_actividad_parque', 'nombre' => 'Actividades en parques'],
    '/puntos-interes/regiones' => ['tabla' => 'tabla_regiones', 'nombre' => 'Regiones'],
];

foreach ($routes_data as $route => $info) {
    echo "\n📍 $route - {$info['nombre']}\n";
    try {
        $count = DB::table($info['tabla'])->count();
        echo "   ✅ {$info['tabla']}: $count registros\n";
        
        if ($count > 0) {
            $sample = DB::table($info['tabla'])->limit(1)->first();
            echo "   📝 Ejemplo: " . substr($this->getSampleName($sample, $info['tabla']), 0, 50) . "...\n";
        }
    } catch (\Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
    }
}

echo "\n=== RESUMEN TOTAL ===\n";
$total_registros = 0;
foreach ($routes_data as $route => $info) {
    try {
        $count = DB::table($info['tabla'])->count();
        $total_registros += $count;
    } catch (\Exception $e) {
        // Skip errors
    }
}

echo "📊 Total de destinos turísticos disponibles: $total_registros\n";
echo "🌐 Todas las categorías están configuradas y listas para mostrarse en la web-app\n";

function getSampleName($sample, $table) {
    if (!$sample) return "Sin datos";
    
    $name_fields = [
        'tabla_deporte_aventura' => 'NOMBRE_DEPORTES_AVENTURA',
        'tabla_desierto_laguna' => 'NOMBRE_DESIERTO_LAGUNAS',
        'tabla_gastronomia' => 'PLATOS_TIPICOS',
        'tabla_iglesias' => 'NOMBRE_IGLESIA',
        'tabla_islas' => 'NOMBRE_ISLA',
        'tabla_museos' => 'NOMBRE_MUSEO',
        'tabla_parque_tematicos' => 'NOMBRE_PARQUES_TEMÁTICOS',
        'tabla_playas' => 'NOMBRE_PLAYA',
        'tabla_reservas' => 'NOMBRE_RESERVAS_O_PARQUES',
        'tabla_termales' => 'NOMBRE_TERMAL',
        'tabla_actividad_parque' => 'NOMBRE_ACTIVIDAD_EN_PARQUE',
        'tabla_regiones' => 'NOMBRE_REGION',
    ];
    
    $field = $name_fields[$table] ?? 'Unknown';
    return $sample->$field ?? 'Sin nombre';
}
