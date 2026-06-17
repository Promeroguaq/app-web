<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== PROBANDO FILTROS DE EVENTOS ===\n";

// Simular diferentes filtros
$test_cases = [
    ['name' => 'Sin filtros', 'params' => []],
    ['name' => 'Búsqueda: Carnaval', 'params' => ['busqueda' => 'Carnaval']],
    ['name' => 'Tipo: carnaval', 'params' => ['tipo' => 'carnaval']],
    ['name' => 'Departamento: Antioquia', 'params' => ['departamento' => 'Antioquia']],
    ['name' => 'Búsqueda: Medellín', 'params' => ['busqueda' => 'Medellín']],
    ['name' => 'Tipo: festival', 'params' => ['tipo' => 'festival']],
    ['name' => 'Departamento: Valle del Cauca', 'params' => ['departamento' => 'Valle del Cauca']],
    ['name' => 'Combinado: tipo=festival + departamento=Antioquia', 'params' => ['tipo' => 'festival', 'departamento' => 'Antioquia']],
];

foreach ($test_cases as $case) {
    echo "\n🔍 {$case['name']}\n";
    echo str_repeat('-', 50) . "\n";
    
    try {
        $query = DB::table('ferias_fiestas');
        
        // Aplicar filtros
        if (isset($case['params']['busqueda'])) {
            $busqueda = $case['params']['busqueda'];
            $query->where(function($q) use ($busqueda) {
                $q->where('NOMBRE_FERIA_FIESTA', 'LIKE', "%{$busqueda}%")
                  ->orWhere('DESCRIPCION', 'LIKE', "%{$busqueda}%")
                  ->orWhere('DEPARTAMENTO', 'LIKE', "%{$busqueda}%")
                  ->orWhere('MUNICIPIO', 'LIKE', "%{$busqueda}%");
            });
        }
        
        if (isset($case['params']['tipo'])) {
            $query->where('TIPO', $case['params']['tipo']);
        }
        
        if (isset($case['params']['departamento'])) {
            $query->where('DEPARTAMENTO', $case['params']['departamento']);
        }
        
        $eventos = $query->orderBy('FECHA_INICIO')->get();
        
        echo "Resultados: " . count($eventos) . " eventos\n";
        
        if (count($eventos) > 0) {
            foreach ($eventos as $evento) {
                echo "- {$evento->NOMBRE_FERIA_FIESTA} ({$evento->DEPARTAMENTO}) - {$evento->TIPO}\n";
            }
        } else {
            echo "No se encontraron eventos\n";
        }
        
    } catch (\Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
}

echo "\n=== VERIFICANDO OPCIONES DE FILTROS ===\n";

$tipos = DB::table('ferias_fiestas')->distinct()->orderBy('TIPO')->pluck('TIPO');
echo "Tipos disponibles: " . implode(', ', $tipos->toArray()) . "\n";

$departamentos = DB::table('ferias_fiestas')->distinct()->orderBy('DEPARTAMENTO')->pluck('DEPARTAMENTO');
echo "Departamentos disponibles: " . implode(', ', $departamentos->toArray()) . "\n";

echo "\n=== URLS DE PRUEBA ===\n";
foreach ($test_cases as $case) {
    if (!empty($case['params'])) {
        $params = http_build_query($case['params']);
        echo "- {$case['name']}: /eventos?{$params}\n";
    }
}
