<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

// Conectar a la base de datos SQLite directamente
$dbPath = database_path('database.sqlite');
$pdo = new PDO('sqlite:' . $dbPath);

// Consultar los datos reales de la tabla actividades_parques (con "s")
$stmt = $pdo->prepare("SELECT id_actividad, nombre_actividad_en_parque, descripcion FROM actividades_parques ORDER BY id_actividad");
$stmt->execute();

echo "=== DATOS REALES DE LA TABLA actividades_parques ===\n\n";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: " . $row['id_actividad'] . "\n";
    echo "Nombre: " . $row['nombre_actividad_en_parque'] . "\n";
    echo "Descripción: " . $row['descripcion'] . "\n";
    echo "----------------------------------------\n";
}

$pdo = null;
