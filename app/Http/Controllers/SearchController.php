<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Playa;
use App\Models\Museo;
use App\Models\DeporteAventura;
use App\Models\Termal;
use App\Models\DesiertoLaguna;
use App\Models\ReservaParque;
use App\Models\Isla;
use App\Models\Iglesia;
use App\Models\ParqueTematico;
use App\Models\FeriaFiesta;
use App\Models\PlatoTipico;
use App\Models\ActividadParque;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Mostrar resultados de búsqueda global
     */
    public function index(Request $request)
    {
        $query = trim($request->get('q', ''));

        // Validar longitud mínima
        if (strlen($query) < 2) {
            return view('pages.busqueda', [
                'query' => $query,
                'results' => [],
                'hasResults' => false,
                'message' => strlen($query) === 0 
                    ? 'Ingresa al menos 2 caracteres para buscar destinos, experiencias o lugares de Colombia.' 
                    : 'Ingresa al menos 2 caracteres para realizar una búsqueda.'
            ]);
        }

        $results = [];
        $totalResults = 0;

        // Buscar en Departamentos
        $departamentos = Departamento::where('NOMBRE_DEPARTAMENTO', 'LIKE', "%{$query}%")
            ->select('ID_DEPARTAMENTO as id', 'NOMBRE_DEPARTAMENTO as nombre', 'NOMBRE_DEPARTAMENTO as slug')
            ->take(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'tipo' => 'Departamento',
                    'categoria' => 'Destinos',
                    'ubicacion' => $item->nombre,
                    'url' => route('departamentos.show', ['id' => $item->id]),
                    'imagen' => $this->buscarImagen($item->nombre)
                ];
            });

        if ($departamentos->isNotEmpty()) {
            $results['Destinos']['Departamentos'] = $departamentos;
            $totalResults += $departamentos->count();
        }

        // Buscar en Municipios
        $municipios = \DB::table('tabla_municipios')
            ->where('NOMBRE_MUNICIPIOS', 'LIKE', "%{$query}%")
            ->select('ID_MUNICIPIOS as id', 'NOMBRE_MUNICIPIOS as nombre', 'ID_DEPARTAMENTO')
            ->take(8)
            ->get();

        $municipiosFormatted = collect();
        foreach ($municipios as $municipio) {
            $depto = \DB::table('tabla_departamentos')
                ->where('ID_DEPARTAMENTO', $municipio->ID_DEPARTAMENTO)
                ->first();

            if ($depto) {
                $deptoSlug = \Illuminate\Support\Str::slug($depto->NOMBRE_DEPARTAMENTO);
                $muniSlug = \Illuminate\Support\Str::slug($municipio->nombre);

                $municipiosFormatted->push([
                    'id' => $municipio->id,
                    'nombre' => $municipio->nombre,
                    'tipo' => 'Municipio',
                    'categoria' => 'Destinos',
                    'ubicacion' => $depto->NOMBRE_DEPARTAMENTO,
                    'url' => route('municipios.show.slugs', [
                        'departmentSlug' => $deptoSlug,
                        'municipalitySlug' => $muniSlug
                    ]),
                    'imagen' => $this->buscarImagen($municipio->nombre)
                ]);
            }
        }

        if ($municipiosFormatted->isNotEmpty()) {
            $results['Destinos']['Municipios'] = $municipiosFormatted;
            $totalResults += $municipiosFormatted->count();
        }

        // Buscar en Playas
        $playas = \DB::table('tabla_playas')
            ->where('NOMBRE_PLAYAS', 'LIKE', "%{$query}%")
            ->select('ID_PLAYAS as id', 'NOMBRE_PLAYAS as nombre')
            ->take(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'tipo' => 'Playa',
                    'categoria' => 'Naturaleza',
                    'ubicacion' => 'Colombia',
                    'url' => route('playas.show', ['id' => $item->id]),
                    'imagen' => $this->buscarImagen($item->nombre)
                ];
            });

        if ($playas->isNotEmpty()) {
            $results['Naturaleza']['Playas'] = $playas;
            $totalResults += $playas->count();
        }

        // Buscar en Museos
        $museos = \DB::table('tabla_museos')
            ->where('NOMBRE_MUSEOS', 'LIKE', "%{$query}%")
            ->select('ID_MUSEOS as id', 'NOMBRE_MUSEOS as nombre')
            ->take(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'tipo' => 'Museo',
                    'categoria' => 'Cultura',
                    'ubicacion' => 'Colombia',
                    'url' => route('museos.show', ['id' => $item->id]),
                    'imagen' => $this->buscarImagen($item->nombre)
                ];
            });

        if ($museos->isNotEmpty()) {
            $results['Cultura']['Museos'] = $museos;
            $totalResults += $museos->count();
        }

        // Buscar en Deportes de Aventura
        $aventura = \DB::table('tabla_deportes_aventura')
            ->where('NOMBRE_DEPORTES_AVENTURA', 'LIKE', "%{$query}%")
            ->select('ID_DEPORTES_AVENTURA as id', 'NOMBRE_DEPORTES_AVENTURA as nombre')
            ->take(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'tipo' => 'Deporte de Aventura',
                    'categoria' => 'Actividades',
                    'ubicacion' => 'Colombia',
                    'url' => route('deportes-aventura.show', ['slug' => \Illuminate\Support\Str::slug($item->nombre)]),
                    'imagen' => $this->buscarImagen($item->nombre)
                ];
            });

        if ($aventura->isNotEmpty()) {
            $results['Actividades']['Deportes de Aventura'] = $aventura;
            $totalResults += $aventura->count();
        }

        // Buscar en Termales
        $termales = \DB::table('tabla_termales')
            ->where('NOMBRE_TERMALES', 'LIKE', "%{$query}%")
            ->select('ID_TERMALES as id', 'NOMBRE_TERMALES as nombre')
            ->take(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'tipo' => 'Termal',
                    'categoria' => 'Naturaleza',
                    'ubicacion' => 'Colombia',
                    'url' => route('puntos-interes.termales.show', ['id' => $item->id]),
                    'imagen' => $this->buscarImagen($item->nombre)
                ];
            });

        if ($termales->isNotEmpty()) {
            $results['Naturaleza']['Termales'] = $termales;
            $totalResults += $termales->count();
        }

        // Buscar en Desiertos/Lagunas
        $desiertos = \DB::table('tabla_desierto_laguna')
            ->where('COL 2', 'LIKE', "%{$query}%")
            ->select('COL 1 as id', 'COL 2 as nombre')
            ->take(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'tipo' => 'Desierto/Laguna',
                    'categoria' => 'Naturaleza',
                    'ubicacion' => 'Colombia',
                    'url' => route('puntos-interes.desiertos-lagunas.show', ['id' => $item->id]),
                    'imagen' => $this->buscarImagen($item->nombre)
                ];
            });

        if ($desiertos->isNotEmpty()) {
            $results['Naturaleza']['Desiertos/Lagunas'] = $desiertos;
            $totalResults += $desiertos->count();
        }

        // Buscar en Reservas/Parques
        $reservas = \DB::table('tabla_reservas')
            ->where('NOMBRE_RESERVAS_O_PARQUES', 'LIKE', "%{$query}%")
            ->select('ID_RESERVAS as id', 'NOMBRE_RESERVAS_O_PARQUES as nombre')
            ->take(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'tipo' => 'Reserva/Parque',
                    'categoria' => 'Naturaleza',
                    'ubicacion' => 'Colombia',
                    'url' => route('reservas-parques.show', ['id' => $item->id]),
                    'imagen' => $this->buscarImagen($item->nombre)
                ];
            });

        if ($reservas->isNotEmpty()) {
            $results['Naturaleza']['Reservas/Parques'] = $reservas;
            $totalResults += $reservas->count();
        }

        // Buscar en Islas
        $islas = \DB::table('tabla_islas')
            ->where('NOMBRE_ISLA', 'LIKE', "%{$query}%")
            ->select('ID_ISLA as id', 'NOMBRE_ISLA as nombre')
            ->take(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'tipo' => 'Isla',
                    'categoria' => 'Destinos',
                    'ubicacion' => 'Colombia',
                    'url' => route('puntos-interes.islas.show', ['id' => $item->id]),
                    'imagen' => $this->buscarImagen($item->nombre)
                ];
            });

        if ($islas->isNotEmpty()) {
            $results['Destinos']['Islas'] = $islas;
            $totalResults += $islas->count();
        }

        // Buscar en Iglesias
        $iglesias = \DB::table('tabla_iglesias')
            ->where('NOMBRE_IGLESIAS', 'LIKE', "%{$query}%")
            ->select('ID_IGLESIAS as id', 'NOMBRE_IGLESIAS as nombre')
            ->take(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'tipo' => 'Iglesia',
                    'categoria' => 'Cultura',
                    'ubicacion' => 'Colombia',
                    'url' => route('puntos-interes.iglesias.show', ['id' => $item->id]),
                    'imagen' => $this->buscarImagen($item->nombre)
                ];
            });

        if ($iglesias->isNotEmpty()) {
            $results['Cultura']['Iglesias'] = $iglesias;
            $totalResults += $iglesias->count();
        }

        // Buscar en Parques Temáticos
        $parques = \DB::table('tabla_parques_tematicos')
            ->where('NOMBRE_PARQUES_TEMATICOS', 'LIKE', "%{$query}%")
            ->select('ID_PARQUES_TEMATICOS as id', 'NOMBRE_PARQUES_TEMATICOS as nombre')
            ->take(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'tipo' => 'Parque Temático',
                    'categoria' => 'Actividades',
                    'ubicacion' => 'Colombia',
                    'url' => route('puntos-interes.parques-tematicos.show', ['id' => $item->id]),
                    'imagen' => $this->buscarImagen($item->nombre)
                ];
            });

        if ($parques->isNotEmpty()) {
            $results['Actividades']['Parques Temáticos'] = $parques;
            $totalResults += $parques->count();
        }

        // Buscar en Ferias/Fiestas
        $ferias = \DB::table('tabla_ferias_fiestas')
            ->where('NOMBRE_FERIAS_FIESTAS', 'LIKE', "%{$query}%")
            ->select('ID_FERIAS_FIESTAS as id', 'NOMBRE_FERIAS_FIESTAS as nombre')
            ->take(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'tipo' => 'Feria/Fiesta',
                    'categoria' => 'Eventos',
                    'ubicacion' => 'Colombia',
                    'url' => route('fiestas-ferias.show', ['id' => $item->id]),
                    'imagen' => $this->buscarImagen($item->nombre)
                ];
            });

        if ($ferias->isNotEmpty()) {
            $results['Eventos']['Ferias/Fiestas'] = $ferias;
            $totalResults += $ferias->count();
        }

        // Buscar en Platos Típicos
        $platos = \DB::table('tabla_platos_tipicos')
            ->where('NOMBRE_PLATOS_TIPICOS', 'LIKE', "%{$query}%")
            ->select('ID_PLATOS_TIPICOS as id', 'NOMBRE_PLATOS_TIPICOS as nombre')
            ->take(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'tipo' => 'Plato Típico',
                    'categoria' => 'Gastronomía',
                    'ubicacion' => 'Colombia',
                    'url' => route('gastronomia.show', ['departmentSlug' => 'colombia', 'platoSlug' => \Illuminate\Support\Str::slug($item->nombre)]),
                    'imagen' => $this->buscarImagen($item->nombre)
                ];
            });

        if ($platos->isNotEmpty()) {
            $results['Gastronomía']['Platos Típicos'] = $platos;
            $totalResults += $platos->count();
        }

        // Buscar en Actividades de Parques
        $actividades = \DB::table('tabla_actividades_parques')
            ->where('NOMBRE_ACTIVIDADES', 'LIKE', "%{$query}%")
            ->select('ID_ACTIVIDADES as id', 'NOMBRE_ACTIVIDADES as nombre')
            ->take(8)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'tipo' => 'Actividad',
                    'categoria' => 'Actividades',
                    'ubicacion' => 'Colombia',
                    'url' => route('actividades.show', ['id' => $item->id]),
                    'imagen' => $this->buscarImagen($item->nombre)
                ];
            });

        if ($actividades->isNotEmpty()) {
            $results['Actividades']['Actividades'] = $actividades;
            $totalResults += $actividades->count();
        }

        $hasResults = $totalResults > 0;
        $message = $hasResults 
            ? "Encontramos {$totalResults} resultados para \"{$query}\"" 
            : "No encontramos resultados para \"{$query}\". Prueba con un destino, ciudad, experiencia o departamento.";

        return view('pages.busqueda', compact(
            'query',
            'results',
            'hasResults',
            'message',
            'totalResults'
        ));
    }

    /**
     * Buscar imagen en tabla_imagenes por nombre
     */
    private function buscarImagen($nombre)
    {
        try {
            if (empty($nombre)) {
                return null;
            }

            $nombreNormalizado = \App\Helpers\ImageHelper::cleanString($nombre);
            $imagen = \DB::table('tabla_imagenes')
                ->select('RUTA')
                ->whereRaw('LOWER(NOMBRE_IMAGEN) LIKE ?', ['%' . strtolower($nombreNormalizado) . '%'])
                ->first();

            return $imagen ? $imagen->RUTA : null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
