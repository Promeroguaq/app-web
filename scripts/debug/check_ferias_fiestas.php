<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICANDO TABLA FERIAS_FIESTAS ===\n";

try {
    // Verificar si la tabla existe
    $tables = DB::select("SHOW TABLES LIKE 'ferias_fiestas'");
    
    if (empty($tables)) {
        echo "❌ La tabla 'ferias_fiestas' no existe\n";
        
        // Verificar si existe tabla_ferias_fiestas
        $tables_alt = DB::select("SHOW TABLES LIKE 'tabla_ferias_fiestas'");
        if (!empty($tables_alt)) {
            echo "✅ Se encontró 'tabla_ferias_fiestas' en su lugar\n";
            $tabla_nombre = 'tabla_ferias_fiestas';
        } else {
            echo "❌ No se encontró ninguna tabla de ferias/fiestas\n";
            exit;
        }
    } else {
        echo "✅ Tabla 'ferias_fiestas' existe\n";
        $tabla_nombre = 'ferias_fiestas';
    }
    
    // Contar registros
    $count = DB::table($tabla_nombre)->count();
    echo "Total de registros: $count\n\n";
    
    if ($count > 0) {
        // Mostrar estructura de la tabla
        echo "=== ESTRUCTURA DE LA TABLA ===\n";
        $columns = DB::select("DESCRIBE $tabla_nombre");
        foreach ($columns as $col) {
            echo "- {$col->Field} ({$col->Type})\n";
        }
        
        echo "\n=== PRIMEROS 5 REGISTROS ===\n";
        $sample = DB::table($tabla_nombre)->limit(5)->get();
        foreach ($sample as $row) {
            echo "---\n";
            foreach ((array)$row as $key => $value) {
                if ($value) {
                    echo "$key: " . substr($value, 0, 50) . (strlen($value) > 50 ? "..." : "") . "\n";
                }
            }
            echo "\n";
        }
    } else {
        echo "⚠️  La tabla está vacía. No hay eventos para mostrar.\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== VERIFICANDO OTRAS TABLAS POSIBLES ===\n";
$all_tables = DB::select("SHOW TABLES");
foreach ($all_tables as $table) {
    $table_name = array_values((array)$table)[0];
    if (stripos($table_name, 'feria') !== false || stripos($table_name, 'fiesta') !== false) {
        echo "Encontrada tabla relacionada: $table_name\n";
        try {
            $count = DB::table($table_name)->count();
            echo "  Registros: $count\n";
        } catch (\Exception $e) {
            echo "  Error al contar: " . $e->getMessage() . "\n";
        }
    }
}
