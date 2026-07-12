<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST DE RESERVAS NATURALES ===\n\n";

// 1. Obtener primer registro real
$reserva = \DB::table('tabla_reservas')->first();

if (!$reserva) {
    echo "ERROR: No hay registros en tabla_reservas\n";
    exit(1);
}

echo "1. Primer registro de tabla_reservas:\n";
echo "   - ID_RESERVAS: {$reserva->ID_RESERVAS}\n";
echo "   - NOMBRE_RESERVAS_O_PARQUES: {$reserva->NOMBRE_RESERVAS_O_PARQUES}\n";
echo "   - ID_LOCALITIES: {$reserva->ID_LOCALITIES}\n";
echo "   - DESCRIPCION: " . substr($reserva->DESCRIPCION ?? '', 0, 50) . "...\n\n";

// 2. Verificar relación con tabla_localities
if ($reserva->ID_LOCALITIES) {
    $locality = \DB::table('tabla_localities')->where('ID', $reserva->ID_LOCALITIES)->first();
    if ($locality) {
        echo "2. Relación con tabla_localities:\n";
        echo "   - MUNICIPIOS: {$locality->MUNICIPIOS}\n";
        echo "   - DEPARTAMENTO: {$locality->DEPARTAMENTO}\n";
        echo "   - REGION: {$locality->REGION}\n\n";
    } else {
        echo "2. WARNING: ID_LOCALITIES {$reserva->ID_LOCALITIES} no existe en tabla_localities\n\n";
    }
} else {
    echo "2. WARNING: Este registro no tiene ID_LOCALITIES\n\n";
}

// 3. Verificar consulta del controlador
echo "3. Verificando consulta del controlador (reservasNaturales):\n";
$reservas = \DB::table('tabla_reservas as r')
    ->leftJoin('tabla_localities as l', 'r.ID_LOCALITIES', '=', 'l.ID')
    ->select([
        'r.ID_RESERVAS',
        'r.NOMBRE_RESERVAS_O_PARQUES',
        'r.DESCRIPCION',
        'r.ID_LOCALITIES',
        'l.MUNICIPIOS as localidad_municipio',
        'l.DEPARTAMENTO as localidad_departamento',
        'l.REGION as localidad_region',
    ])
    ->get();

echo "   - Total registros: {$reservas->count()}\n";

$primeraReserva = $reservas->first();
if ($primeraReserva) {
    echo "   - Primera reserva:\n";
    echo "     * id: {$primeraReserva->ID_RESERVAS}\n";
    echo "     * nombre: {$primeraReserva->NOMBRE_RESERVAS_O_PARQUES}\n";
    echo "     * localidad: {$primeraReserva->localidad_municipio}\n";
    echo "     * departamento: {$primeraReserva->localidad_departamento}\n";
    echo "     * region: {$primeraReserva->localidad_region}\n\n";
}

// 4. Verificar consulta de detalle
echo "4. Verificando consulta de detalle (show):\n";
$detalle = \DB::table('tabla_reservas')
    ->leftJoin('tabla_localities as locality', 'tabla_reservas.ID_LOCALITIES', '=', 'locality.ID')
    ->select(
        'tabla_reservas.*',
        'locality.MUNICIPIOS as locality_municipio',
        'locality.DEPARTAMENTO as locality_departamento',
        'locality.REGION as locality_region'
    )
    ->where('ID_RESERVAS', $reserva->ID_RESERVAS)
    ->first();

if ($detalle) {
    echo "   - Reserva encontrada por ID_RESERVAS: {$reserva->ID_RESERVAS} ✓\n";
    echo "   - Nombre: {$detalle->NOMBRE_RESERVAS_O_PARQUES}\n";
    echo "   - Municipio: {$detalle->locality_municipio}\n";
    echo "   - Departamento: {$detalle->locality_departamento}\n\n";
} else {
    echo "   - ERROR: No se encontró reserva por ID_RESERVAS\n\n";
}

// 5. Verificar rutas
echo "5. Verificando rutas:\n";
$routes = \Illuminate\Support\Facades\Route::getRoutes();

$rutaIndex = $routes->getByName('puntos-interes.reservas-naturales');
$rutaShow = $routes->getByName('puntos-interes.reservas-naturales.show');

if ($rutaIndex) {
    echo "   - puntos-interes.reservas-naturales: ✓\n";
    echo "     Controller: {$rutaIndex->getControllerClass()}@{$rutaIndex->getActionMethod()}\n";
} else {
    echo "   - puntos-interes.reservas-naturales: ✗ NO ENCONTRADA\n";
}

if ($rutaShow) {
    echo "   - puntos-interes.reservas-naturales.show: ✓\n";
    echo "     Controller: {$rutaShow->getControllerClass()}@{$rutaShow->getActionMethod()}\n";
    echo "     URI: {$rutaShow->uri}\n";
} else {
    echo "   - puntos-interes.reservas-naturales.show: ✗ NO ENCONTRADA\n";
}

// 6. Generar URLs
echo "\n6. URLs generadas:\n";
$urlIndex = route('puntos-interes.reservas-naturales');
$urlShow = route('puntos-interes.reservas-naturales.show', ['id' => $reserva->ID_RESERVAS]);

echo "   - Listado: {$urlIndex}\n";
echo "   - Detalle: {$urlShow}\n\n";

// 7. Verificar modelo
echo "7. Verificando modelo ReservaParque:\n";
$modelo = new \App\Models\ReservaParque();
echo "   - Table: {$modelo->getTable()}\n";
echo "   - Primary Key: {$modelo->getKeyName()}\n";
echo "   - Timestamps: " . ($modelo->timestamps ? 'true' : 'false') . "\n\n";

echo "=== FINALIZADO ===\n";
