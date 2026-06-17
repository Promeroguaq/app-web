<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

// Conectar a la base de datos SQLite directamente
$dbPath = database_path('database.sqlite');
$pdo = new PDO('sqlite:' . $dbPath);

// Verificar estructura de la tabla actividades_parques
$stmt = $pdo->prepare("PRAGMA table_info(actividades_parques)");
$stmt->execute();

echo "=== ESTRUCTURA DE LA TABLA actividades_parques ===\n\n";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Columna: " . $row['name'] . "\n";
    echo "Tipo: " . $row['type'] . "\n";
    echo "------------------------\n";
}

echo "\n";

// Verificar si hay datos en la tabla
$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM actividades_parques");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Total de registros: " . $result['count'] . "\n";

if ($result['count'] > 0) {
    // Intentar obtener los datos con diferentes nombres de columna posibles
    try {
        // Primero intentar con nombres en mayúsculas (como en la imagen)
        $stmt = $pdo->prepare("SELECT * FROM actividades_parques ORDER BY rowid LIMIT 3");
        $stmt->execute();
        
        echo "\n=== PRIMEROS 3 REGISTROS (estructura completa) ===\n\n";
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Registro completo:\n";
            foreach ($row as $key => $value) {
                echo "  $key: $value\n";
            }
            echo "----------------------------------------\n";
        }
        
        // Ahora intentar con los nombres de columna de la imagen
        echo "\n=== INTENTANDO CON NOMBRES DE COLUMNA DE LA IMAGEN ===\n\n";
        
        $stmt = $pdo->prepare("SELECT ID_ACTIVIDAD, NOMBRE_ACTIVIDAD_EN_PARQUE, ID_LOCALITITES, DESCRIPCION FROM actividades_parques ORDER BY rowid LIMIT 5");
        $stmt->execute();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "ID_ACTIVIDAD: " . $row['ID_ACTIVIDAD'] . "\n";
            echo "NOMBRE_ACTIVIDAD_EN_PARQUE: " . $row['NOMBRE_ACTIVIDAD_EN_PARQUE'] . "\n";
            echo "ID_LOCALITITES: " . $row['ID_LOCALITITES'] . "\n";
            echo "DESCRIPCION: " . $row['DESCRIPCION'] . "\n";
            echo "----------------------------------------\n";
        }
        
    } catch (PDOException $e) {
        echo "Error al consultar con nombres de mayúsculas: " . $e->getMessage() . "\n";
        
        // Intentar con nombres en minúsculas
        try {
            $stmt = $pdo->prepare("SELECT id_actividad, nombre_actividad_en_parque, id_localitites, descripcion FROM actividades_parques ORDER BY rowid LIMIT 5");
            $stmt->execute();
            
            echo "\n=== USANDO NOMBRES EN MINÚSCULAS ===\n\n";
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "id_actividad: " . $row['id_actividad'] . "\n";
                echo "nombre_actividad_en_parque: " . $row['nombre_actividad_en_parque'] . "\n";
                echo "id_localitites: " . $row['id_localitites'] . "\n";
                echo "descripcion: " . $row['descripcion'] . "\n";
                echo "----------------------------------------\n";
            }
        } catch (PDOException $e2) {
            echo "Error al consultar con nombres de minúsculas: " . $e2->getMessage() . "\n";
        }
    }
}

$pdo = null;
