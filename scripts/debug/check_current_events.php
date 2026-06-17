<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICANDO EVENTOS ACTUALES ===\n";

try {
    $eventos = DB::table('ferias_fiestas')->get();
    echo "Total de eventos en BD: " . count($eventos) . "\n\n";
    
    echo "=== EVENTOS ACTUALES ===\n";
    foreach ($eventos as $evento) {
        echo "- {$evento->NOMBRE_FERIA_FIESTA} ({$evento->DEPARTAMENTO})\n";
    }
    
    echo "\n=== AGREGANDO MÁS EVENTOS Y FIESTAS DE COLOMBIA ===\n";
    
    // Agregar más eventos y fiestas de Colombia
    $mas_eventos = [
        [
            'NOMBRE_FERIA_FIESTA' => 'Festival de la Cosecha',
            'TIPO' => 'festival',
            'DEPARTAMENTO' => 'Boyacá',
            'MUNICIPIO' => 'Tunja',
            'FECHA_INICIO' => '2024-06-15',
            'FECHA_FIN' => '2024-06-20',
            'DESCRIPCION' => 'Festival que celebra la cosecha de productos agrícolas de la región con desfiles, música tradicional y gastronomía local.',
            'PRECIO' => 0,
            'IMAGEN' => 'https://images.unsplash.com/photo-1598595537244-6d5b6cf2c9c3?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Feria del Libro',
            'TIPO' => 'feria',
            'DEPARTAMENTO' => 'Cundinamarca',
            'MUNICIPIO' => 'Bogotá',
            'FECHA_INICIO' => '2024-04-20',
            'FECHA_FIN' => '2024-05-05',
            'DESCRIPCION' => 'La feria del libro más importante de Colombia, con participación de autores nacionales e internacionales, presentaciones y actividades culturales.',
            'PRECIO' => 15000,
            'IMAGEN' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Festival de Jazz y Blues',
            'TIPO' => 'festival',
            'DEPARTAMENTO' => 'Santander',
            'MUNICIPIO' => 'Bucaramanga',
            'FECHA_INICIO' => '2024-08-15',
            'FECHA_FIN' => '2024-08-18',
            'DESCRIPCION' => 'Festival que reúne a los mejores músicos de jazz y blues de Colombia y el extranjero en un ambiente único en la ciudad bonita.',
            'PRECIO' => 60000,
            'IMAGEN' => 'https://images.unsplash.com/photo-1511192336575-5a791e3f32bf?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Feria de San Pacho',
            'TIPO' => 'feria',
            'DEPARTAMENTO' => 'Antioquia',
            'MUNICIPIO' => 'Quibdó',
            'FECHA_INICIO' => '2024-09-20',
            'FECHA_FIN' => '2024-09-25',
            'DESCRIPCION' => 'Celebración tradicional de la cultura afrocolombiana con música, bailes, gastronomía y actividades religiosas.',
            'PRECIO' => 0,
            'IMAGEN' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Festival del Dulce',
            'TIPO' => 'festival',
            'DEPARTAMENTO' => 'Valle del Cauca',
            'MUNICIPIO' => 'Cali',
            'FECHA_INICIO' => '2024-10-10',
            'FECHA_FIN' => '2024-10-15',
            'DESCRIPCION' => 'Festival que celebra la tradición dulcera del Valle del Cauca con exhibiciones, concursos y venta de dulces típicos.',
            'PRECIO' => 5000,
            'IMAGEN' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Carnaval de Riosucio',
            'TIPO' => 'carnaval',
            'DEPARTAMENTO' => 'Caldas',
            'MUNICIPIO' => 'Riosucio',
            'FECHA_INICIO' => '2024-01-05',
            'FECHA_FIN' => '2024-01-07',
            'DESCRIPCION' => 'Carnaval conocido por sus coloridas comparsas y mascaradas que representan la diversidad cultural del municipio.',
            'PRECIO' => 20000,
            'IMAGEN' => 'https://images.unsplash.com/photo-1543369867-f9131e5e9dc1?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Festival del Mar',
            'TIPO' => 'festival',
            'DEPARTAMENTO' => 'Bolívar',
            'MUNICIPIO' => 'Cartagena',
            'FECHA_INICIO' => '2024-07-15',
            'FECHA_FIN' => '2024-07-21',
            'DESCRIPCION' => 'Celebración de la cultura marítima de Cartagena con regatas, música caribeña, gastronomía y actividades acuáticas.',
            'PRECIO' => 0,
            'IMAGEN' => 'https://images.unsplash.com/photo-1519904981063-b0cf448d479e?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Feria de Manizales',
            'TIPO' => 'feria',
            'DEPARTAMENTO' => 'Caldas',
            'MUNICIPIO' => 'Manizales',
            'FECHA_INICIO' => '2024-01-01',
            'FECHA_FIN' => '2024-01-10',
            'DESCRIPCION' => 'La feria más importante de la región cafetera con espectáculos taurinos, conciertos, desfiles y eventos culturales.',
            'PRECIO' => 35000,
            'IMAGEN' => 'https://images.unsplash.com/photo-1516173662650-4db559094e00?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Festival de Teatro de Manizales',
            'TIPO' => 'festival',
            'DEPARTAMENTO' => 'Caldas',
            'MUNICIPIO' => 'Manizales',
            'FECHA_INICIO' => '2024-03-01',
            'FECHA_FIN' => '2024-03-10',
            'DESCRIPCION' => 'Festival teatral que reúne a las mejores compañías de teatro de Colombia y América Latina.',
            'PRECIO' => 40000,
            'IMAGEN' => 'https://images.unsplash.com/photo-1503095396549-807759245b35?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Carnaval de El Banco',
            'TIPO' => 'carnaval',
            'DEPARTAMENTO' => 'Magdalena',
            'MUNICIPIO' => 'El Banco',
            'FECHA_INICIO' => '2024-12-20',
            'FECHA_FIN' => '2024-12-23',
            'DESCRIPCION' => 'Carnaval conocido por el festival de la leyenda vallenata y las actividades culturales de la región.',
            'PRECIO' => 0,
            'IMAGEN' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Feria de la Panela',
            'TIPO' => 'feria',
            'DEPARTAMENTO' => 'Santander',
            'MUNICIPIO' => 'San Gil',
            'FECHA_INICIO' => '2024-05-15',
            'FECHA_FIN' => '2024-05-20',
            'DESCRIPCION' => 'Feria que celebra la producción de panela con actividades gastronómicas, culturales y comerciales.',
            'PRECIO' => 3000,
            'IMAGEN' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Festival de la Arepa',
            'TIPO' => 'festival',
            'DEPARTAMENTO' => 'Antioquia',
            'MUNICIPIO' => 'Medellín',
            'FECHA_INICIO' => '2024-09-05',
            'FECHA_FIN' => '2024-09-08',
            'DESCRIPCION' => 'Festival dedicado a la arepa, símbolo de la gastronomía colombiana, con concursos, degustaciones y actividades culturales.',
            'PRECIO' => 10000,
            'IMAGEN' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Feria del Ganado',
            'TIPO' => 'feria',
            'DEPARTAMENTO' => 'Meta',
            'MUNICIPIO' => 'Villavicencio',
            'FECHA_INICIO' => '2024-06-01',
            'FECHA_FIN' => '2024-06-07',
            'DESCRIPCION' => 'La feria ganadera más importante de la Orinoquía con exhibiciones de ganado, concursos y eventos culturales llaneros.',
            'PRECIO' => 15000,
            'IMAGEN' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Festival de la Cultura Wayuu',
            'TIPO' => 'festival',
            'DEPARTAMENTO' => 'La Guajira',
            'MUNICIPIO' => 'Uribia',
            'FECHA_INICIO' => '2024-08-20',
            'FECHA_FIN' => '2024-08-25',
            'DESCRIPCION' => 'Festival que celebra la cultura indígena Wayuu con música, danza, artesanías y gastronomía tradicional.',
            'PRECIO' => 0,
            'IMAGEN' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&h=400&fit=crop'
        ],
        [
            'NOMBRE_FERIA_FIESTA' => 'Feria del Café',
            'TIPO' => 'feria',
            'DEPARTAMENTO' => 'Quindío',
            'MUNICIPIO' => 'Armenia',
            'FECHA_INICIO' => '2024-06-10',
            'FECHA_FIN' => '2024-06-15',
            'DESCRIPCION' => 'Feria que celebra el café colombiano con catas, tours a fincas, concursos y actividades culturales del Eje Cafetero.',
            'PRECIO' => 8000,
            'IMAGEN' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600&h=400&fit=crop'
        ]
    ];
    
    // Insertar los nuevos eventos
    foreach ($mas_eventos as $evento) {
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
    
    echo "✅ " . count($mas_eventos) . " eventos adicionales insertados\n";
    
    // Verificar total final
    $total_final = DB::table('ferias_fiestas')->count();
    echo "\n📊 Total final de eventos: $total_final\n";
    
    echo "\n=== TODOS LOS EVENTOS DISPONIBLES ===\n";
    $todos_eventos = DB::table('ferias_fiestas')->orderBy('NOMBRE_FERIA_FIESTA')->get();
    foreach ($todos_eventos as $evento) {
        echo "- {$evento->NOMBRE_FERIA_FIESTA} ({$evento->DEPARTAMENTO}) - {$evento->TIPO}\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
