<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

// Probar conexión a la base de datos usando la configuración del .env
try {
    echo "=== PROBANDO CONEXIÓN A LA BASE DE DATOS ===\n\n";
    
    // Mostrar configuración actual
    echo "DB_CONNECTION: " . env('DB_CONNECTION') . "\n";
    echo "DB_HOST: " . env('DB_HOST') . "\n";
    echo "DB_PORT: " . env('DB_PORT') . "\n";
    echo "DB_DATABASE: " . env('DB_DATABASE') . "\n";
    echo "DB_USERNAME: " . env('DB_USERNAME') . "\n";
    echo "DB_PASSWORD: " . (env('DB_PASSWORD') ? '***OCULTO***' : 'VACÍO') . "\n\n";
    
    // Intentar conexión
    $pdo = new PDO(
        env('DB_CONNECTION') . ':host=' . env('DB_HOST') . ';port=' . env('DB_PORT') . ';dbname=' . env('DB_DATABASE'),
        env('DB_USERNAME'),
        env('DB_PASSWORD')
    );
    
    echo "✅ CONEXIÓN EXITOSA\n\n";
    
    // Listar todas las tablas
    $stmt = $pdo->prepare("SHOW TABLES");
    $stmt->execute();
    
    echo "=== TABLAS EN LA BASE DE DATOS ===\n\n";
    
    $tables = [];
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $tables[] = $row[0];
        echo "- " . $row[0] . "\n";
    }
    
    echo "\n";
    
    // Verificar si existe tabla_actividad_parque o similar
    $actividadTables = array_filter($tables, function($table) {
        return stripos($table, 'actividad') !== false || stripos($table, 'parque') !== false;
    });
    
    if (!empty($actividadTables)) {
        echo "=== TABLAS RELACIONADAS CON ACTIVIDADES/PARQUES ===\n\n";
        foreach ($actividadTables as $table) {
            echo "- " . $table . "\n";
        }
    } else {
        echo "❌ NO SE ENCONTRARON TABLAS RELACIONADAS CON ACTIVIDADES O PARQUES\n\n";
    }
    
    // Verificar estructura de la tabla si existe
    if (in_array('tabla_actividad_parque', $tables)) {
        echo "\n=== ESTRUCTURA DE tabla_actividad_parque ===\n\n";
        
        $stmt = $pdo->prepare("DESCRIBE tabla_actividad_parque");
        $stmt->execute();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Columna: " . $row['Field'] . "\n";
            echo "Tipo: " . $row['Type'] . "\n";
            echo "------------------------\n";
        }
        
        // Contar registros
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM tabla_actividad_parque");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "\nTotal de registros: " . $result['count'] . "\n";
        
        if ($result['count'] > 0) {
            echo "\n=== PRIMEROS 3 REGISTROS ===\n\n";
            
            $stmt = $pdo->prepare("SELECT * FROM tabla_actividad_parque LIMIT 3");
            $stmt->execute();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                foreach ($row as $key => $value) {
                    echo "$key: $value\n";
                }
                echo "------------------------\n";
            }
        }
    }
    
} catch (PDOException $e) {
    echo "❌ ERROR DE CONEXIÓN: " . $e->getMessage() . "\n";
    echo "Código de error: " . $e->getCode() . "\n";
}
