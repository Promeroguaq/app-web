<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

// Conectar a la base de datos SQLite directamente
$dbPath = database_path('database.sqlite');
$pdo = new PDO('sqlite:' . $dbPath);

// Verificar si existe la tabla tabla_actividad_parque
$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM sqlite_master WHERE type='table' AND name='tabla_actividad_parque'");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo "¿Existe tabla 'tabla_actividad_parque'? " . ($result['count'] > 0 ? 'SÍ' : 'NO') . "\n\n";

if ($result['count'] > 0) {
    // Verificar estructura de la tabla
    $stmt = $pdo->prepare("PRAGMA table_info(tabla_actividad_parque)");
    $stmt->execute();

    echo "=== ESTRUCTURA DE LA TABLA tabla_actividad_parque ===\n\n";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Columna: " . $row['name'] . "\n";
        echo "Tipo: " . $row['type'] . "\n";
        echo "------------------------\n";
    }

    // Verificar si hay datos en la tabla
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM tabla_actividad_parque");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "\nTotal de registros: " . $result['count'] . "\n";

    if ($result['count'] > 0) {
        // Mostrar todos los datos con las columnas correctas
        $stmt = $pdo->prepare("SELECT * FROM tabla_actividad_parque ORDER BY ID_ACTIVIDAD");
        $stmt->execute();
        
        echo "\n=== DATOS REALES DE tabla_actividad_parque ===\n\n";
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "ID_ACTIVIDAD: " . $row['ID_ACTIVIDAD'] . "\n";
            echo "NOMBRE_ACTIVIDAD_EN_PARQUE: " . $row['NOMBRE_ACTIVIDAD_EN_PARQUE'] . "\n";
            echo "ID_LOCALITITES: " . $row['ID_LOCALITITES'] . "\n";
            echo "DESCRIPCION: " . $row['DESCRIPCION'] . "\n";
            echo "----------------------------------------\n";
        }
    }
} else {
    // Listar todas las tablas para ver cuál podría ser la correcta
    $stmt = $pdo->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name LIKE '%actividad%'");
    $stmt->execute();
    
    echo "=== TABLAS QUE CONTIENEN 'actividad' ===\n\n";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- " . $row['name'] . "\n";
    }
}

$pdo = null;
