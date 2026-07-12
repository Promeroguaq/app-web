<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST DE URLs DE CATEGORÍAS CORREGIDAS ===\n\n";

// URLs a probar
$urls = [
    'Deportes de Aventura' => '/puntos-interes/deportes-aventura',
    'Playas' => '/puntos-interes/playas',
    'Reservas Naturales' => '/puntos-interes/reservas-naturales',
    'Fiestas y Ferias' => '/puntos-interes/fiestas-ferias',
];

foreach ($urls as $nombre => $url) {
    echo "Probando: $nombre ($url)\n";
    
    try {
        // Obtener el primer registro de la tabla correspondiente
        $tabla = match($nombre) {
            'Deportes de Aventura' => 'tabla_deporte_aventura',
            'Playas' => 'tabla_playas',
            'Reservas Naturales' => 'tabla_reservas',
            'Fiestas y Ferias' => 'tabla_ferias',
        };
        
        $pk = match($nombre) {
            'Deportes de Aventura' => 'ID_DEPORTES',
            'Playas' => 'ID_PLAYA',
            'Reservas Naturales' => 'ID_RESERVAS',
            'Fiestas y Ferias' => 'ID_FIESTA',
        };
        
        $primerRegistro = \DB::table($tabla)->first();
        
        if ($primerRegistro) {
            $id = $primerRegistro->$pk;
            $urlDetalle = str_replace('{id}', $id, $url . '/{id}');
            
            echo "  - Primer ID: $id\n";
            echo "  - URL detalle: $urlDetalle\n";
            
            // Verificar que el controlador exista
            $controller = match($nombre) {
                'Deportes de Aventura' => 'App\Http\Controllers\DeporteAventuraController',
                'Playas' => 'App\Http\Controllers\PlayaController',
                'Reservas Naturales' => 'App\Http\Controllers\ReservaParqueController',
                'Fiestas y Ferias' => 'App\Http\Controllers\FeriaController',
            };
            
            if (class_exists($controller)) {
                echo "  - Controlador: $controller ✓\n";
            } else {
                echo "  - Controlador: $controller ✗ (NO EXISTE)\n";
            }
        } else {
            echo "  - No hay registros en la tabla\n";
        }
    } catch (\Exception $e) {
        echo "  - Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

echo "=== VERIFICACIÓN DE RUTAS ===\n\n";

try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    
    $rutasEsperadas = [
        'puntos-interes.deportes-aventura',
        'puntos-interes.deportes-aventura.show',
        'puntos-interes.playas',
        'puntos-interes.playas.show',
        'puntos-interes.reservas-naturales',
        'puntos-interes.reservas-naturales.show',
        'puntos-interes.fiestas-ferias',
    ];
    
    foreach ($rutasEsperadas as $nombreRuta) {
        $ruta = $routes->getByName($nombreRuta);
        if ($ruta) {
            $controller = $ruta->getControllerClass();
            $action = $ruta->getActionMethod();
            echo "✓ $nombreRuta -> $controller@$action\n";
        } else {
            echo "✗ $nombreRuta (NO ENCONTRADA)\n";
        }
    }
} catch (\Exception $e) {
    echo "Error al verificar rutas: " . $e->getMessage() . "\n";
}

echo "\n=== FINALIZADO ===\n";
