<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Municipio;
use Illuminate\Http\Request;

class RutasTuristicasController extends Controller
{
    /**
     * Mostrar página principal de rutas turísticas
     */
    public function index()
    {
        // Obtener departamentos ordenados por nombre
        $departamentos = Departamento::orderBy('NOMBRE_DEPARTAMENTO')->get();
        
        // Obtener municipios ordenados por nombre
        $municipios = Municipio::orderBy('NOMBRE_MUNICIPIOS')->take(12)->get();

        // Datos de ejemplo de rutas (simulados)
        $rutas = [
            [
                'id' => 1,
                'nombre' => 'Ruta Cafetera',
                'dificultad' => 'Fácil',
                'descripcion' => 'Recorre los hermosos paisajes cafeteros del Eje Cafetero, visitando fincas tradicionales y disfrutando de la cultura cafetera.',
                'departamento' => 'Quindío',
                'distancia' => 120,
                'duracion' => 3,
                'punto_inicio' => 'Armenia',
                'punto_fin' => 'Salento',
                'precio' => 350000
            ],
            [
                'id' => 2,
                'nombre' => 'Ruta del Sol',
                'dificultad' => 'Moderada',
                'descripcion' => 'Disfruta de las mejores playas del Caribe colombiano, desde Santa Marta hasta Cartagena.',
                'departamento' => 'Atlántico',
                'distancia' => 200,
                'duracion' => 5,
                'punto_inicio' => 'Santa Marta',
                'punto_fin' => 'Cartagena',
                'precio' => 850000
            ],
            [
                'id' => 3,
                'nombre' => 'Ruta de los Volcanes',
                'dificultad' => 'Difícil',
                'descripcion' => 'Aventura extrema por los volcanes del sur de Colombia, incluyendo el Nevado del Huila.',
                'departamento' => 'Huila',
                'distancia' => 150,
                'duracion' => 7,
                'punto_inicio' => 'Neiva',
                'punto_fin' => 'San Agustín',
                'precio' => 1200000
            ],
            [
                'id' => 4,
                'nombre' => 'Ruta Colonial',
                'dificultad' => 'Fácil',
                'descripcion' => 'Viaja en el tiempo por los pueblos coloniales de Boyacá y Cundinamarca.',
                'departamento' => 'Boyacá',
                'distancia' => 180,
                'duracion' => 4,
                'punto_inicio' => 'Tunja',
                'punto_fin' => 'Villa de Leyva',
                'precio' => 450000
            ],
            [
                'id' => 5,
                'nombre' => 'Ruta Amazonas',
                'dificultad' => 'Difícil',
                'descripcion' => 'Expedición profunda por la selva amazónica colombiana.',
                'departamento' => 'Amazonas',
                'distancia' => 300,
                'duracion' => 10,
                'punto_inicio' => 'Leticia',
                'punto_fin' => 'Puerto Nariño',
                'precio' => 2500000
            ],
            [
                'id' => 6,
                'nombre' => 'Ruta del Pacifico',
                'dificultad' => 'Moderada',
                'descripcion' => 'Descubre la costa pacífica y sus ballenas jorobadas.',
                'departamento' => 'Chocó',
                'distancia' => 250,
                'duracion' => 6,
                'punto_inicio' => 'Nuquí',
                'punto_fin' => 'Bahía Solano',
                'precio' => 980000
            ]
        ];

        try {
            // Enviar datos a la vista
            return view('pages.rutas-turisticas', compact('departamentos', 'municipios', 'rutas'));
        } catch (\Exception $e) {
            return view('pages.rutas-turisticas', [
                'departamentos' => collect([]),
                'municipios' => collect([]),
                'rutas' => [],
                'error' => 'Error al cargar las rutas turísticas: ' . $e->getMessage()
            ]);
        }
    }
}
