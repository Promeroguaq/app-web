<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AlojamientoController extends Controller
{
    /**
     * Mostrar página principal de alojamiento
     */
    public function index()
    {
        // Cachear consultas por 1 hora
        $departamentos = Cache::remember('aloj_deptos', 3600, function () {
            return Departamento::orderBy('NOMBRE_DEPARTAMENTO')->get();
        });
        
        $municipios = Cache::remember('aloj_munic', 3600, function () {
            return Municipio::orderBy('NOMBRE_MUNICIPIOS')->take(12)->get();
        });

        return view('pages.alojamiento', compact('departamentos', 'municipios'));
    }

    /**
     * Mostrar casas de huéspedes
     */
    public function casasDeHuespedes()
    {
        // Obtener departamentos para filtrar
        $departamentos = Departamento::orderBy('NOMBRE_DEPARTAMENTO')->get();
        
        // Obtener municipios para filtrar
        $municipios = Municipio::orderBy('NOMBRE_MUNICIPIOS')->take(12)->get();

        // Datos de ejemplo para casas de huéspedes
        $casas = collect([
            (object)['id' => 1, 'nombre' => 'Casa del Sol', 'departamento' => 'Antioquia', 'municipio' => 'Medellín', 'precio' => 85000, 'habitaciones' => 3],
            (object)['id' => 2, 'nombre' => 'Villa Peace', 'departamento' => 'Cundinamarca', 'municipio' => 'Bogotá', 'precio' => 120000, 'habitaciones' => 4],
            (object)['id' => 3, 'nombre' => 'Café House', 'departamento' => 'Quindío', 'municipio' => 'Armenia', 'precio' => 65000, 'habitaciones' => 2],
            (object)['id' => 4, 'nombre' => 'Mountain View', 'departamento' => 'Boyacá', 'municipio' => 'Tunja', 'precio' => 55000, 'habitaciones' => 3],
        ]);

        return view('pages.alojamiento.casas-de-huespedes', compact('departamentos', 'municipios', 'casas'));
    }

    /**
     * Mostrar eco-lodges
     */
    public function ecoLodges()
    {
        // Obtener departamentos para filtrar
        $departamentos = Departamento::orderBy('NOMBRE_DEPARTAMENTO')->get();
        
        // Obtener municipios para filtrar
        $municipios = Municipio::orderBy('NOMBRE_MUNICIPIOS')->take(12)->get();

        // Datos de ejemplo para eco-lodges
        $lodges = collect([
            (object)['id' => 1, 'nombre' => 'Amazonia Eco Lodge', 'departamento' => 'Amazonas', 'municipio' => 'Leticia', 'precio' => 150000, 'rating' => 4.8],
            (object)['id' => 2, 'nombre' => 'Sierra Verde', 'departamento' => 'Magdalena', 'municipio' => 'Santa Marta', 'precio' => 180000, 'rating' => 4.9],
            (object)['id' => 3, 'nombre' => 'Coffee Forest', 'departamento' => 'Caldas', 'municipio' => 'Manizales', 'precio' => 135000, 'rating' => 4.7],
            (object)['id' => 4, 'nombre' => 'Pacific Paradise', 'departamento' => 'Chocó', 'municipio' => 'Nuquí', 'precio' => 200000, 'rating' => 5.0],
        ]);

        return view('pages.alojamiento.eco-lodges', compact('departamentos', 'municipios', 'lodges'));
    }

    /**
     * Mostrar resorts
     */
    public function resorts()
    {
        // Obtener departamentos para filtrar
        $departamentos = Departamento::orderBy('NOMBRE_DEPARTAMENTO')->get();
        
        // Obtener municipios para filtrar
        $municipios = Municipio::orderBy('NOMBRE_MUNICIPIOS')->take(12)->get();

        // Datos de ejemplo para resorts
        $resorts = collect([
            (object)['id' => 1, 'nombre' => 'Caribbean Resort', 'departamento' => 'San Andrés', 'municipio' => 'San Andrés', 'precio' => 450000, 'estrellas' => 5],
            (object)['id' => 2, 'nombre' => 'Pacific Paradise Resort', 'departamento' => 'Valle del Cauca', 'municipio' => 'Buenaventura', 'precio' => 380000, 'estrellas' => 4],
            (object)['id' => 3, 'nombre' => 'Andes Luxury', 'departamento' => 'Risaralda', 'municipio' => 'Pereira', 'precio' => 320000, 'estrellas' => 4],
            (object)['id' => 4, 'nombre' => 'Sun Beach Resort', 'departamento' => 'Atlántico', 'municipio' => 'Barranquilla', 'precio' => 280000, 'estrellas' => 3],
        ]);

        return view('pages.alojamiento.resorts', compact('departamentos', 'municipios', 'resorts'));
    }
}
