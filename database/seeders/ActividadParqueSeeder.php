<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActividadParqueSeeder extends Seeder
{
    public function run(): void
    {
        $actividades = [
            [
                'id_actividad' => 1,
                'nombre_actividad_en_parque' => 'OBSERVACIÓN FAUNA Y FLORA',
                'id_localitites' => 13,
                'descripcion' => 'Observación de la diversidad de fauna y flora en su hábitat natural',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 2,
                'nombre_actividad_en_parque' => 'OBSERVACION AVES',
                'id_localitites' => 13,
                'descripcion' => 'Avistamiento de aves en su entorno natural',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 3,
                'nombre_actividad_en_parque' => 'TURISMO CULTURAL',
                'id_localitites' => 13,
                'descripcion' => 'Actividades culturales y educativas en los parques',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 4,
                'nombre_actividad_en_parque' => 'TREKKING',
                'id_localitites' => 13,
                'descripcion' => 'Caminatas y senderismo por rutas naturales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 5,
                'nombre_actividad_en_parque' => 'MONTAÑISMO',
                'id_localitites' => 13,
                'descripcion' => 'Escalada y ascenso a montañas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 6,
                'nombre_actividad_en_parque' => 'BUCEO',
                'id_localitites' => 13,
                'descripcion' => 'Buceo submarino para explorar la vida marina',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 7,
                'nombre_actividad_en_parque' => 'SNORKELLING O CARETEO',
                'id_localitites' => 13,
                'descripcion' => 'Natación con snorkel para observar el fondo marino',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 8,
                'nombre_actividad_en_parque' => 'SOL Y PLAYA',
                'id_localitites' => 13,
                'descripcion' => 'Disfrute de playas y actividades acuáticas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 9,
                'nombre_actividad_en_parque' => 'OBSERVACIÓN ESTELAR',
                'id_localitites' => 13,
                'descripcion' => 'Observación de estrellas y fenómenos astronómicos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 10,
                'nombre_actividad_en_parque' => 'OBSERVACIÓN BALLENAS',
                'id_localitites' => 13,
                'descripcion' => 'Avistamiento de ballenas en su hábitat natural',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 11,
                'nombre_actividad_en_parque' => 'OBSERVACION GEOLÓGICA',
                'id_localitites' => 13,
                'descripcion' => 'Estudio y observación de formaciones geológicas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 12,
                'nombre_actividad_en_parque' => 'FOTOGRAFIA Y VIDEO',
                'id_localitites' => 13,
                'descripcion' => 'Captura fotográfica y video de paisajes naturales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 13,
                'nombre_actividad_en_parque' => 'OBSERVACION DE MARIPOSAS E INSECTOS',
                'id_localitites' => 13,
                'descripcion' => 'Observación de mariposas e insectos en su entorno',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 14,
                'nombre_actividad_en_parque' => 'ESCALADA EN ROCA',
                'id_localitites' => 13,
                'descripcion' => 'Escalada en paredes rocosas naturales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 15,
                'nombre_actividad_en_parque' => 'CICLOMONTAÑISMO',
                'id_localitites' => 13,
                'descripcion' => 'Ciclismo de montaña por senderos naturales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 16,
                'nombre_actividad_en_parque' => 'MEDITACIÓN (BIENESTAR Y SALUD)',
                'id_localitites' => 13,
                'descripcion' => 'Actividades de meditación y bienestar en la naturaleza',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 17,
                'nombre_actividad_en_parque' => 'ESPELEISMO',
                'id_localitites' => 13,
                'descripcion' => 'Exploración de cuevas y cavernas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 18,
                'nombre_actividad_en_parque' => 'PESCA DE CONTROL',
                'id_localitites' => 13,
                'descripcion' => 'Pesca deportiva con fines de conservación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 19,
                'nombre_actividad_en_parque' => 'PASEO ACUATICO',
                'id_localitites' => 13,
                'descripcion' => 'Paseos en embarcaciones por ríos y lagos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 20,
                'nombre_actividad_en_parque' => 'CAMPING / ACAMPAR',
                'id_localitites' => 13,
                'descripcion' => 'Acampada en zonas designadas de los parques',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 21,
                'nombre_actividad_en_parque' => 'GLAMPING',
                'id_localitites' => 13,
                'descripcion' => 'Alojamiento de lujo en la naturaleza',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_actividad' => 22,
                'nombre_actividad_en_parque' => 'SENDERISMO',
                'id_localitites' => 13,
                'descripcion' => 'Caminatas por senderos señalizados en la naturaleza',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('tabla_actividad_parques')->insert($actividades);
    }
}
