<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CREANDO ESTRUCTURA Y DATOS PARA EVENTOS ===\n";

try {
    // Primero, vamos a agregar las columnas que faltan a la tabla ferias_fiestas
    DB::statement("ALTER TABLE ferias_fiestas 
        ADD COLUMN NOMBRE_FERIA_FIESTA VARCHAR(255) AFTER id,
        ADD COLUMN TIPO VARCHAR(100) AFTER NOMBRE_FERIA_FIESTA,
        ADD COLUMN DEPARTAMENTO VARCHAR(100) AFTER TIPO,
        ADD COLUMN MUNICIPIO VARCHAR(100) AFTER DEPARTAMENTO,
        ADD COLUMN FECHA_INICIO DATE AFTER MUNICIPIO,
        ADD COLUMN FECHA_FIN DATE AFTER FECHA_INICIO,
        ADD COLUMN DESCRIPCION TEXT AFTER FECHA_FIN,
        ADD COLUMN PRECIO DECIMAL(10,2) DEFAULT 0 AFTER DESCRIPCION,
        ADD COLUMN IMAGEN VARCHAR(500) NULL AFTER PRECIO");
    
    echo "✅ Columnas agregadas a la tabla ferias_fiestas\n";
    
    // Ahora insertar datos de ejemplo
    $eventos_ejemplo = [
        [
            'NOMBRE_FERIA_FIESTA' => 'Carnaval de Barranquilla',
            'TIPO' => 'carnaval',
            'DEPARTAMENTO' => 'Atlántico',
            'MUNICIPIO' => 'Barranquilla',
            'FECHA_INICIO' => '2024-02-10',
            'FECHA_FIN' => '2024-02-13',
            'DESCRIPCION' => 'El Carnaval de Barranquilla es una de las fiestas más importantes y representativas de Colombia. Celebrado cuatro días antes del Miércoles de Ceniza, este carnaval destaca por sus coloridos desfiles, música de cumbia y vallenato, y la tradición del "Joselito Carnaval".',
            'PRECIO' => 0,
            'IMAGEN' => 'https://images.unsplash.com/photo-1519904981063-b0cf448d479e?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Festival Iberoamericano de Teatro de Bogotá',
            'TIPO' => 'festival',
            'DEPARTAMENTO' => 'Cundinamarca',
            'MUNICIPIO' => 'Bogotá',
            'FECHA_INICIO' => '2024-03-15',
            'FECHA_FIN' => '2024-03-30',
            'DESCRIPCION' => 'El FITBO es el festival de teatro más importante de América Latina, reuniendo a las mejores compañías teatrales de Iberoamérica durante dos semanas de representaciones en diferentes escenarios de la capital.',
            'PRECIO' => 50000,
            'IMAGEN' => 'https://images.unsplash.com/photo-1503095396549-807759245b35?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Festival Internacional de Poesía de Medellín',
            'TIPO' => 'festival',
            'DEPARTAMENTO' => 'Antioquia',
            'MUNICIPIO' => 'Medellín',
            'FECHA_INICIO' => '2024-06-20',
            'FECHA_FIN' => '2024-06-28',
            'DESCRIPCION' => 'Un festival que reúne a poetas de todo el mundo en las calles de Medellín, promoviendo la poesía como herramienta de transformación social y paz.',
            'PRECIO' => 0,
            'IMAGEN' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Feria de las Flores de Medellín',
            'TIPO' => 'feria',
            'DEPARTAMENTO' => 'Antioquia',
            'MUNICIPIO' => 'Medellín',
            'FECHA_INICIO' => '2024-08-01',
            'FECHA_FIN' => '2024-08-10',
            'DESCRIPCION' => 'La Feria de las Flores celebra la belleza y diversidad de las flores de Colombia con desfiles de silleteros, conciertos, eventos culturales y la exhibición de las más hermosas orquídeas.',
            'PRECIO' => 25000,
            'IMAGEN' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Rock al Parque Bogotá',
            'TIPO' => 'festival',
            'DEPARTAMENTO' => 'Cundinamarca',
            'MUNICIPIO' => 'Bogotá',
            'FECHA_INICIO' => '2024-09-15',
            'FECHA_FIN' => '2024-09-17',
            'DESCRIPCION' => 'El festival de rock más grande de América Latina, gratuito y al aire libre, que presenta a bandas nacionales e internacionales en el Parque Simón Bolívar.',
            'PRECIO' => 0,
            'IMAGEN' => 'https://images.unsplash.com/photo-1464665480529-4b4b73b9a264?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Feria de Cali',
            'TIPO' => 'feria',
            'DEPARTAMENTO' => 'Valle del Cauca',
            'MUNICIPIO' => 'Cali',
            'FECHA_INICIO' => '2024-12-25',
            'FECHA_FIN' => '2025-01-02',
            'DESCRIPCION' => 'La Feria de Cali es una celebración de la cultura caleña, famosa por sus conciertos de salsa, el desfile de silleteros, eventos taurinos y espectáculos culturales.',
            'PRECIO' => 30000,
            'IMAGEN' => 'https://images.unsplash.com/photo-1516173662650-4db559094e00?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Festival de la Leyenda Vallenata',
            'TIPO' => 'festival',
            'DEPARTAMENTO' => 'Cesar',
            'MUNICIPIO' => 'Valledupar',
            'FECHA_INICIO' => '2024-04-29',
            'FECHA_FIN' => '2024-05-01',
            'DESCRIPCION' => 'Festival que celebra el vallenato, género musical patrimonio cultural de Colombia, con conciertos de los mejores acordeoneros y cantantes del país.',
            'PRECIO' => 45000,
            'IMAGEN' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Carnaval de Negros y Blancos',
            'TIPO' => 'carnaval',
            'DEPARTAMENTO' => 'Nariño',
            'MUNICIPIO' => 'Pasto',
            'FECHA_INICIO' => '2025-01-02',
            'FECHA_FIN' => '2025-01-07',
            'DESCRIPCION' => 'Declarado Patrimonio Cultural Inmaterial de la Humanidad por la UNESCO, este carnaval celebra la diversidad cultural con el famoso desfile de las carrozas y el juego de agua y espuma.',
            'PRECIO' => 0,
            'IMAGEN' => 'https://images.unsplash.com/photo-1531059212993-19d75aebd90b?w=600&h=400&fit=crop'
        ]
    ];
    
    // Insertar los datos
    foreach ($eventos_ejemplo as $evento) {
        DB::table('ferias_fiestas')->insert([
            'NOMBRE_FERIA_FIESTA' => $evento['NOMBRE_FERIA_FIESTA'],
            'TIPO' => $evento['TIPO'],
            'DEPARTAMENTO' => $evento['DEPARTAMENTO'],
            'MUNICIPIO' => $evento['MUNICIPIO'],
            'FECHA_INICIO' => $evento['FECHA_INICIO'],
            'FECHA_FIN' => $evento['FECHA_FIN'],
            'DESCRIPCION' => $evento['DESCRIPCION'],
            'PRECIO' => $evento['PRECIO'],
            'IMAGEN' => $evento['IMAGEN'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
    
    echo "✅ " . count($eventos_ejemplo) . " eventos de ejemplo insertados\n";
    
    // Verificar que se insertaron correctamente
    $total = DB::table('ferias_fiestas')->count();
    echo "\n📊 Total de eventos en la BD: $total\n";
    
    echo "\n=== EVENTOS CREADOS ===\n";
    $eventos_creados = DB::table('ferias_fiestas')->get();
    foreach ($eventos_creados as $evento) {
        echo "- {$evento->NOMBRE_FERIA_FIESTA} ({$evento->TIPO}) - {$evento->DEPARTAMENTO}\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    
    // Si las columnas ya existen, intentamos solo insertar datos
    if (strpos($e->getMessage(), 'Duplicate column') !== false) {
        echo "\n⚠️  Las columnas ya existen. Intentando insertar solo datos...\n";
        
        try {
            // Insertar datos de ejemplo
            $eventos_ejemplo = [
                [
                    'NOMBRE_FERIA_FIESTA' => 'Carnaval de Barranquilla',
                    'TIPO' => 'carnaval',
                    'DEPARTAMENTO' => 'Atlántico',
                    'MUNICIPIO' => 'Barranquilla',
                    'FECHA_INICIO' => '2024-02-10',
                    'FECHA_FIN' => '2024-02-13',
                    'DESCRIPCION' => 'El Carnaval de Barranquilla es una de las fiestas más importantes y representativas de Colombia. Celebrado cuatro días antes del Miércoles de Ceniza, este carnaval destaca por sus coloridos desfiles, música de cumbia y vallenato, y la tradición del "Joselito Carnaval".',
                    'PRECIO' => 0,
                    'IMAGEN' => 'https://images.unsplash.com/photo-1519904981063-b0cf448d479e?w=600&h=400&fit=crop'
                ],
                [
                    'NOMBRE_FERIA_FIESTA' => 'Feria de las Flores de Medellín',
                    'TIPO' => 'feria',
                    'DEPARTAMENTO' => 'Antioquia',
                    'MUNICIPIO' => 'Medellín',
                    'FECHA_INICIO' => '2024-08-01',
                    'FECHA_FIN' => '2024-08-10',
                    'DESCRIPCION' => 'La Feria de las Flores celebra la belleza y diversidad de las flores de Colombia con desfiles de silleteros, conciertos, eventos culturales y la exhibición de las más hermosas orquídeas.',
                    'PRECIO' => 25000,
                    'IMAGEN' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&h=400&fit=crop'
                ],
                [
                    'NOMBRE_FERIA_FIESTA' => 'Rock al Parque Bogotá',
                    'TIPO' => 'festival',
                    'DEPARTAMENTO' => 'Cundinamarca',
                    'MUNICIPIO' => 'Bogotá',
                    'FECHA_INICIO' => '2024-09-15',
                    'FECHA_FIN' => '2024-09-17',
                    'DESCRIPCION' => 'El festival de rock más grande de América Latina, gratuito y al aire libre, que presenta a bandas nacionales e internacionales en el Parque Simón Bolívar.',
                    'PRECIO' => 0,
                    'IMAGEN' => 'https://images.unsplash.com/photo-1464665480529-4b4b73b9a264?w=600&h=400&fit=crop'
                ]
            ];
            
            foreach ($eventos_ejemplo as $evento) {
                DB::table('ferias_fiestas')->insert([
                    'NOMBRE_FERIA_FIESTA' => $evento['NOMBRE_FERIA_FIESTA'],
                    'TIPO' => $evento['TIPO'],
                    'DEPARTAMENTO' => $evento['DEPARTAMENTO'],
                    'MUNICIPIO' => $evento['MUNICIPIO'],
                    'FECHA_INICIO' => $evento['FECHA_INICIO'],
                    'FECHA_FIN' => $evento['FECHA_FIN'],
                    'DESCRIPCION' => $evento['DESCRIPCION'],
                    'PRECIO' => $evento['PRECIO'],
                    'IMAGEN' => $evento['IMAGEN'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            
            echo "✅ Datos insertados correctamente\n";
        } catch (\Exception $e2) {
            echo "❌ Error al insertar datos: " . $e2->getMessage() . "\n";
        }
    }
}
