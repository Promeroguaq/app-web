<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICANDO ESTRUCTURA COMPLETA DE FERIAS_FIESTAS ===\n";

try {
    // Mostrar estructura completa
    $columns = DB::select("DESCRIBE ferias_fiestas");
    echo "Columnas encontradas:\n";
    foreach ($columns as $col) {
        echo "- {$col->Field} ({$col->Type}) - {$col->Null} - {$col->Key}\n";
    }
    
    echo "\n=== VERIFICANDO SI EXISTEN DATOS EN OTRAS TABLAS SIMILARES ===\n";
    
    // Buscar en todas las tablas si hay eventos
    $all_tables = DB::select("SHOW TABLES");
    
    foreach ($all_tables as $table) {
        $table_name = array_values((array)$table)[0];
        
        // Buscar tablas que puedan contener eventos
        if (stripos($table_name, 'feria') !== false || 
            stripos($table_name, 'fiesta') !== false ||
            stripos($table_name, 'evento') !== false ||
            stripos($table_name, 'festival') !== false) {
            
            echo "\n🔍 Revisando tabla: $table_name\n";
            
            try {
                $count = DB::table($table_name)->count();
                echo "   Registros: $count\n";
                
                if ($count > 0) {
                    // Mostrar estructura y un ejemplo
                    $cols = DB::select("DESCRIBE $table_name");
                    echo "   Columnas: ";
                    $col_names = [];
                    foreach ($cols as $col) {
                        $col_names[] = $col->Field;
                    }
                    echo implode(", ", $col_names) . "\n";
                    
                    // Mostrar primer registro
                    $sample = DB::table($table_name)->limit(1)->first();
                    echo "   Ejemplo:\n";
                    foreach ((array)$sample as $key => $value) {
                        if ($value && strlen($value) < 100) {
                            echo "     $key: $value\n";
                        } elseif ($value) {
                            echo "     $key: " . substr($value, 0, 50) . "...\n";
                        }
                    }
                }
            } catch (\Exception $e) {
                echo "   Error: " . $e->getMessage() . "\n";
            }
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
