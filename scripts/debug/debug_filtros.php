<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEPURANDO FILTROS ===\n";

// Simular una petición GET con filtros
$_GET['tipo'] = 'carnaval';
$_GET['departamento'] = 'Antioquia';

// Crear una petición simulada
$request = new \Illuminate\Http\Request($_GET);

try {
    // Simular el código del controlador
    $query = \DB::table('ferias_fiestas');
    
    echo "Parámetros recibidos:\n";
    echo "- tipo: " . $request->get('tipo') . "\n";
    echo "- departamento: " . $request->get('departamento') . "\n";
    echo "- busqueda: " . $request->get('busqueda') . "\n\n";
    
    // Aplicar filtros si existen
    if ($request->filled('busqueda')) {
        $busqueda = $request->get('busqueda');
        echo "✅ Aplicando filtro de búsqueda: $busqueda\n";
        $query->where(function($q) use ($busqueda) {
            $q->where('NOMBRE_FERIA_FIESTA', 'LIKE', "%{$busqueda}%")
              ->orWhere('DESCRIPCION', 'LIKE', "%{$busqueda}%")
              ->orWhere('DEPARTAMENTO', 'LIKE', "%{$busqueda}%")
              ->orWhere('MUNICIPIO', 'LIKE', "%{$busqueda}%");
        });
    } else {
        echo "❌ No se aplicó filtro de búsqueda (vacío)\n";
    }
    
    if ($request->filled('tipo')) {
        $tipo = $request->get('tipo');
        echo "✅ Aplicando filtro de tipo: $tipo\n";
        $query->where('TIPO', $tipo);
    } else {
        echo "❌ No se aplicó filtro de tipo (vacío)\n";
    }
    
    if ($request->filled('departamento')) {
        $depto = $request->get('departamento');
        echo "✅ Aplicando filtro de departamento: $depto\n";
        $query->where('DEPARTAMENTO', $depto);
    } else {
        echo "❌ No se aplicó filtro de departamento (vacío)\n";
    }
    
    // Obtener eventos filtrados
    $eventos = $query->orderBy('FECHA_INICIO')->get();
    
    echo "\nResultados: " . count($eventos) . " eventos encontrados\n";
    
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

echo "\n=== VERIFICANDO FILTROS INDIVIDUALES ===\n";

// Probar filtro individual de tipo
echo "\n🔍 Solo tipo=carnaval:\n";
$eventos_tipo = \DB::table('ferias_fiestas')->where('TIPO', 'carnaval')->get();
echo "Resultados: " . count($eventos_tipo) . "\n";

// Probar filtro individual de departamento
echo "\n🔍 Solo departamento=Antioquia:\n";
$eventos_depto = \DB::table('ferias_fiestas')->where('DEPARTAMENTO', 'Antioquia')->get();
echo "Resultados: " . count($eventos_depto) . "\n";

// Probar combinación (no debería haber resultados)
echo "\n🔍 Combinado (carnaval + Antioquia):\n";
$eventos_comb = \DB::table('ferias_fiestas')
    ->where('TIPO', 'carnaval')
    ->where('DEPARTAMENTO', 'Antioquia')
    ->get();
echo "Resultados: " . count($eventos_comb) . "\n";
if (count($eventos_comb) > 0) {
    foreach ($eventos_comb as $evento) {
        echo "- {$evento->NOMBRE_FERIA_FIESTA}\n";
    }
}
