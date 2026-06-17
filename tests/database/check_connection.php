<?php

// Verificar configuración actual
echo "=== VERIFICACIÓN DE CONEXIÓN A BASE DE DATOS ===\n\n";

// Mostrar variables de entorno
echo "Variables de entorno actuales:\n";
echo "DB_CONNECTION: " . (getenv('DB_CONNECTION') ?: 'no definida') . "\n";
echo "DB_HOST: " . (getenv('DB_HOST') ?: 'no definida') . "\n";
echo "DB_PORT: " . (getenv('DB_PORT') ?: 'no definida') . "\n";
echo "DB_DATABASE: " . (getenv('DB_DATABASE') ?: 'no definida') . "\n";
echo "DB_USERNAME: " . (getenv('DB_USERNAME') ?: 'no definida') . "\n";
echo "DB_PASSWORD: " . (getenv('DB_PASSWORD') ? '***definida***' : 'no definida') . "\n\n";

// Intentar conexión directa con MySQL
try {
    echo "Intentando conexión directa con MySQL...\n";
    
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $database = getenv('DB_DATABASE') ?: 'App';
    $username = getenv('DB_USERNAME') ?: 'root';
    $password = getenv('DB_PASSWORD') ?: '';
    
    $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
    
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Conexión MySQL exitosa\n";
    echo "Base de datos: $database\n\n";
    
    // Listar tablas
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Tablas encontradas:\n";
    foreach ($tables as $table) {
        echo "  - $table\n";
    }
    
    // Verificar tabla específica
    $targetTable = 'tabla_actividad_parque';
    if (in_array($targetTable, $tables)) {
        echo "\n✅ Tabla '$targetTable' existe\n";
        
        $stmt = $pdo->query("SELECT COUNT(*) FROM $targetTable");
        $count = $stmt->fetchColumn();
        echo "Registros en '$targetTable': $count\n";
        
        // Mostrar estructura
        $stmt = $pdo->query("DESCRIBE $targetTable");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "\nEstructura de '$targetTable':\n";
        foreach ($columns as $column) {
            echo "  - {$column['Field']} ({$column['Type']})\n";
        }
    } else {
        echo "\n❌ Tabla '$targetTable' no encontrada\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Error de conexión MySQL: " . $e->getMessage() . "\n";
    
    // Intentar con SQLite
    try {
        echo "\nIntentando conexión con SQLite...\n";
        $sqlitePath = __DIR__ . '/database/database.sqlite';
        
        if (file_exists($sqlitePath)) {
            $pdo = new PDO("sqlite:$sqlitePath");
            echo "✅ Conexión SQLite exitosa\n";
            
            $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            echo "Tablas SQLite encontradas:\n";
            foreach ($tables as $table) {
                echo "  - $table\n";
            }
        } else {
            echo "❌ Archivo SQLite no encontrado en: $sqlitePath\n";
        }
    } catch (PDOException $e2) {
        echo "❌ Error de conexión SQLite: " . $e2->getMessage() . "\n";
    }
}

echo "\n=== FIN DE VERIFICACIÓN ===\n";
