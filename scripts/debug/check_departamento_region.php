<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== AUDITORÍA DE DEPARTAMENTO-REGIÓN EN tabla_localities ===\n\n";

$results = DB::select("
    SELECT 
        DEPARTAMENTO, 
        COUNT(DISTINCT REGION) AS total_regiones, 
        GROUP_CONCAT(DISTINCT REGION ORDER BY REGION SEPARATOR ' | ') AS regiones
    FROM tabla_localities 
    WHERE DEPARTAMENTO IS NOT NULL 
      AND DEPARTAMENTO <> ''
    GROUP BY DEPARTAMENTO 
    ORDER BY total_regiones DESC, DEPARTAMENTO
");

$ambiguous = [];
foreach ($results as $row) {
    echo sprintf("%-20s | Regiones: %d | %s\n", 
        $row->DEPARTAMENTO, 
        $row->total_regiones, 
        $row->regiones
    );
    
    if ($row->total_regiones > 1) {
        $ambiguous[] = $row;
    }
}

echo "\n=== DEPARTAMENTOS AMBIGUOS (más de una región) ===\n";
if (empty($ambiguous)) {
    echo "✓ Ningún departamento tiene múltiples regiones\n";
} else {
    foreach ($ambiguous as $row) {
        echo sprintf("⚠ %s tiene %d regiones: %s\n", 
            $row->DEPARTAMENTO, 
            $row->total_regiones, 
            $row->regiones
        );
    }
}
