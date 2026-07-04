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
        try {
            $playas = \DB::table('tabla_playas')
                ->where('NOMBRE_PLAYA', 'LIKE', '%' . $query . '%')
                ->select([
                    'ID_PLAYA as search_id',
                    'NOMBRE_PLAYA as search_nombre',
                ])
                ->take(8)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->search_id,
                        'nombre' => $item->search_nombre,
                        'tipo' => 'Playa',
                        'categoria' => 'Naturaleza',
                        'ubicacion' => 'Colombia',
                        'url' => route('puntos-interes.playas.show', [
                            'id' => $item->search_id,
                        ]),
                        'imagen' => $this->buscarImagen($item->search_nombre),
                    ];
                });
        } catch (\Throwable $exception) {
            logger()->warning('Error searching beaches', [
                'message' => $exception->getMessage(),
            ]);
            $playas = collect();
        }

        if ($playas->isNotEmpty()) {
            $results['Naturaleza']['Playas'] = $playas;
            $totalResults += $playas->count();
        }

        // Buscar en Museos
        try {
            $museos = \DB::table('tabla_museos')
                ->where('NOMBRE_MUSEO', 'LIKE', '%' . $query . '%')
                ->select([
                    'COL 1 as search_id',
                    'NOMBRE_MUSEO as search_nombre',
                ])
                ->take(8)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->search_id,
                        'nombre' => $item->search_nombre,
                        'tipo' => 'Museo',
                        'categoria' => 'Cultura',
                        'ubicacion' => 'Colombia',
                        'url' => route('puntos-interes.museos.show', [
                            'id' => $item->search_id,
                        ]),
                        'imagen' => $this->buscarImagen($item->search_nombre)
                    ];
                });
        } catch (\Throwable $exception) {
            logger()->warning('Error searching museums', [
                'message' => $exception->getMessage(),
            ]);
            $museos = collect();
        }

        if ($museos->isNotEmpty()) {
            $results['Cultura']['Museos'] = $museos;
            $totalResults += $museos->count();
        }

        // Buscar en Deportes de Aventura
        try {
            $aventura = \DB::table('tabla_deporte_aventura')
                ->where('NOMBRE_DEPORTE_AVENTURA', 'LIKE', '%' . $query . '%')
                ->select([
                    'ID_DEPORTES as search_id',
                    'NOMBRE_DEPORTE_AVENTURA as search_nombre',
                ])
                ->take(8)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->search_id,
                        'nombre' => $item->search_nombre,
                        'tipo' => 'Deporte de Aventura',
                        'categoria' => 'Actividades',
                        'ubicacion' => 'Colombia',
                        'url' => route('puntos-interes.deportes-aventura.show', ['slug' => \Illuminate\Support\Str::slug($item->search_nombre)]),
                        'imagen' => $this->buscarImagen($item->search_nombre)
                    ];
                });
        } catch (\Throwable $exception) {
            logger()->warning('Error searching adventure sports', [
                'message' => $exception->getMessage(),
            ]);
            $aventura = collect();
        }

        if ($aventura->isNotEmpty()) {
            $results['Actividades']['Deportes de Aventura'] = $aventura;
            $totalResults += $aventura->count();
        }

        // Buscar en Termales
        try {
            $termales = \DB::table('tabla_termales')
                ->where('NOMBRE_TERMAL', 'LIKE', '%' . $query . '%')
                ->select([
                    'ID_TERMALES as search_id',
                    'NOMBRE_TERMAL as search_nombre',
                ])
                ->take(8)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->search_id,
                        'nombre' => $item->search_nombre,
                        'tipo' => 'Termal',
                        'categoria' => 'Naturaleza',
                        'ubicacion' => 'Colombia',
                        'url' => route('puntos-interes.termales.show', ['id' => $item->search_id]),
                        'imagen' => $this->buscarImagen($item->search_nombre)
                    ];
                });
        } catch (\Throwable $exception) {
            logger()->warning('Error searching thermal springs', [
                'message' => $exception->getMessage(),
            ]);
            $termales = collect();
        }

        if ($termales->isNotEmpty()) {
            $results['Naturaleza']['Termales'] = $termales;
            $totalResults += $termales->count();
        }

        // Buscar en Desiertos/Lagunas
        try {
            $desiertos = \DB::table('tabla_desierto_laguna')
                ->where('NOMBRE_DESIERTO_LAGUNAS', 'LIKE', '%' . $query . '%')
                ->select('ID_DESIERTO as id', 'NOMBRE_DESIERTO_LAGUNAS as nombre')
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
        } catch (\Throwable $exception) {
            logger()->warning('Error searching deserts/lagoons', [
                'message' => $exception->getMessage(),
            ]);
            $desiertos = collect();
        }

        if ($desiertos->isNotEmpty()) {
            $results['Naturaleza']['Desiertos/Lagunas'] = $desiertos;
            $totalResults += $desiertos->count();
        }

        // Buscar en Reservas/Parques
        try {
            $reservas = \DB::table('tabla_reservas')
                ->where('NOMBRE_RESERVAS_O_PARQUES', 'LIKE', '%' . $query . '%')
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
        } catch (\Throwable $exception) {
            logger()->warning('Error searching reserves/parks', [
                'message' => $exception->getMessage(),
            ]);
            $reservas = collect();
        }

        if ($reservas->isNotEmpty()) {
            $results['Naturaleza']['Reservas/Parques'] = $reservas;
            $totalResults += $reservas->count();
        }

        // Buscar en Islas
        try {
            $islas = \DB::table('tabla_islas')
                ->where('NOMBRE_ISLA', 'LIKE', '%' . $query . '%')
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
        } catch (\Throwable $exception) {
            logger()->warning('Error searching islands', [
                'message' => $exception->getMessage(),
            ]);
            $islas = collect();
        }

        if ($islas->isNotEmpty()) {
            $results['Destinos']['Islas'] = $islas;
            $totalResults += $islas->count();
        }

        // Buscar en Iglesias
        try {
            $iglesias = \DB::table('tabla_iglesias')
                ->where('NOMBRE_IGLESIA', 'LIKE', '%' . $query . '%')
                ->select('ID_IGLESIA as id', 'NOMBRE_IGLESIA as nombre')
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
        } catch (\Throwable $exception) {
            logger()->warning('Error searching churches', [
                'message' => $exception->getMessage(),
            ]);
            $iglesias = collect();
        }

        if ($iglesias->isNotEmpty()) {
            $results['Cultura']['Iglesias'] = $iglesias;
            $totalResults += $iglesias->count();
        }

        // Buscar en Parques Temáticos
        try {
            $parques = \DB::table('tabla_parque_tematicos')
                ->where('NOMBRE_PARQUES_TEMÁTICOS', 'LIKE', '%' . $query . '%')
                ->select([
                    'ID_PARQUES as search_id',
                    'NOMBRE_PARQUES_TEMÁTICOS as search_nombre',
                ])
                ->take(8)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->search_id,
                        'nombre' => $item->search_nombre,
                        'tipo' => 'Parque Temático',
                        'categoria' => 'Actividades',
                        'ubicacion' => 'Colombia',
                        'url' => route('puntos-interes.parques-tematicos.show', ['id' => $item->search_id]),
                        'imagen' => $this->buscarImagen($item->search_nombre)
                    ];
                });
        } catch (\Throwable $exception) {
            logger()->warning('Error searching theme parks', [
                'message' => $exception->getMessage(),
            ]);
            $parques = collect();
        }

        if ($parques->isNotEmpty()) {
            $results['Actividades']['Parques Temáticos'] = $parques;
            $totalResults += $parques->count();
        }

        // Buscar en Ferias/Fiestas
        try {
            $ferias = \DB::table('tabla_ferias')
                ->where('NOMBRE_FERIAS_Y_FIESTAS', 'LIKE', '%' . $query . '%')
                ->select('ID_FIESTA as id', 'NOMBRE_FERIAS_Y_FIESTAS as nombre')
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
        } catch (\Throwable $exception) {
            logger()->warning('Error searching fairs/festivals', [
                'message' => $exception->getMessage(),
            ]);
            $ferias = collect();
        }

        if ($ferias->isNotEmpty()) {
            $results['Eventos']['Ferias/Fiestas'] = $ferias;
            $totalResults += $ferias->count();
        }

        // Buscar en Platos Típicos
        try {
            $platos = \DB::table('tabla_gastronomia')
                ->where('PLATOS_TIPICOS', 'LIKE', '%' . $query . '%')
                ->select('ID_PLATOS as id', 'PLATOS_TIPICOS as nombre')
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
        } catch (\Throwable $exception) {
            logger()->warning('Error searching typical dishes', [
                'message' => $exception->getMessage(),
            ]);
            $platos = collect();
        }

        if ($platos->isNotEmpty()) {
            $results['Gastronomía']['Platos Típicos'] = $platos;
            $totalResults += $platos->count();
        }

        // Buscar en Actividades de Parques
        try {
            $actividades = \DB::table('tabla_actividad_parque')
                ->where('NOMBRE_ACTIVIDAD_EN_PARQUE', 'LIKE', '%' . $query . '%')
                ->select('ID_ACTIVIDAD as id', 'NOMBRE_ACTIVIDAD_EN_PARQUE as nombre')
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
        } catch (\Throwable $exception) {
            logger()->warning('Error searching park activities', [
                'message' => $exception->getMessage(),
            ]);
            $actividades = collect();
        }

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
