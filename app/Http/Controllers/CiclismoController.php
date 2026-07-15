<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class CiclismoController extends Controller
{
    public function index()
    {
        try {
            set_time_limit(120);

            // Obtener rutas de ciclismo con LEFT JOIN a tabla_localities
            $rutas = \DB::table('tabla_ciclismo')
                ->leftJoin('tabla_localities as locality', 'tabla_ciclismo.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_ciclismo.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->limit(50)
                ->get();

            \Log::info('Rutas de ciclismo encontradas: ' . $rutas->count());

            if ($rutas->count() === 0) {
                return view('pages.ciclismo', [
                    'items' => collect([]),
                    'error' => 'No hay rutas de ciclismo registradas en la base de datos.'
                ]);
            }

            $rutas_con_imagenes = $rutas->map(function($ruta) {
                $nombre = $ruta->NOMBRE_RUTA_CICLISMO ?? null;
                $descripcion = $ruta->DESCRIPCION ?? null;
                $id = $ruta->ID_CICLISMO ?? null;
                $slug = $ruta->slug ?? null;

                $imagen = ImageHelper::getCategoriaImage('ciclismo', $nombre);

                // Construir ubicación
                $ubicacion = 'Ubicación por confirmar';
                if (isset($ruta->locality_municipio) && $ruta->locality_municipio) {
                    if (isset($ruta->locality_departamento) && $ruta->locality_departamento) {
                        $ubicacion = $ruta->locality_municipio . ', ' . $ruta->locality_departamento;
                    } else {
                        $ubicacion = $ruta->locality_municipio;
                    }
                } elseif (isset($ruta->locality_departamento) && $ruta->locality_departamento) {
                    $ubicacion = $ruta->locality_departamento;
                }

                return (object)[
                    'id' => $id,
                    'nombre' => $nombre ?? 'Sin nombre',
                    'descripcion' => $descripcion ?? 'Sin descripción disponible',
                    'imagen' => $imagen,
                    'slug' => $slug,
                    'localidad' => $ubicacion,
                    'locality_municipio' => $ruta->locality_municipio,
                    'locality_departamento' => $ruta->locality_departamento,
                    'locality_region' => $ruta->locality_region,
                ];
            });

            return view('pages.ciclismo', ['items' => $rutas_con_imagenes]);
        } catch (\Exception $e) {
            \Log::error('Error en CiclismoController: ' . $e->getMessage());
            return view('pages.ciclismo', [
                'items' => collect([]),
                'error' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try {
            set_time_limit(60);

            $ruta = \DB::table('tabla_ciclismo')
                ->leftJoin('tabla_localities as locality', 'tabla_ciclismo.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_ciclismo.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->where('tabla_ciclismo.ID_CICLISMO', $id)
                ->first();

            if (!$ruta) {
                abort(404);
            }

            $nombre = $ruta->NOMBRE_RUTA_CICLISMO ?? 'Sin nombre';
            $descripcion = $ruta->DESCRIPCION ?? 'Sin descripción disponible';
            $imagen = ImageHelper::getCategoriaImage('ciclismo', $nombre);

            // Construir ubicación
            $ubicacion = 'Ubicación por confirmar';
            if (isset($ruta->locality_municipio) && $ruta->locality_municipio) {
                if (isset($ruta->locality_departamento) && $ruta->locality_departamento) {
                    $ubicacion = $ruta->locality_municipio . ', ' . $ruta->locality_departamento;
                } else {
                    $ubicacion = $ruta->locality_municipio;
                }
            } elseif (isset($ruta->locality_departamento) && $ruta->locality_departamento) {
                $ubicacion = $ruta->locality_departamento;
            }

            $item = (object)[
                'id' => $ruta->ID_CICLISMO,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'imagen' => $imagen,
                'slug' => $ruta->slug,
                'ubicacion' => $ubicacion,
                'locality_municipio' => $ruta->locality_municipio,
                'locality_departamento' => $ruta->locality_departamento,
                'locality_region' => $ruta->locality_region,
            ];

            return view('pages.detalle-ciclismo', compact('item'))->with('tipo', 'Ruta de Ciclismo');
        } catch (\Exception $e) {
            \Log::error('Error en CiclismoController show: ' . $e->getMessage());
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_ruta_ciclismo' => 'required|string',
            'id_localities' => 'required|exists:tabla_localities,ID',
            'descripcion' => 'nullable|string'
        ]);

        return \DB::table('tabla_ciclismo')->insert([
            'NOMBRE_RUTA_CICLISMO' => $request->nombre_ruta_ciclismo,
            'ID_LOCALITIES' => $request->id_localities,
            'DESCRIPCION' => $request->descripcion,
            'slug' => \Illuminate\Support\Str::slug($request->nombre_ruta_ciclismo)
        ]);
    }

    public function update(Request $request, $id)
    {
        $ruta = \DB::table('tabla_ciclismo')->where('ID_CICLISMO', $id)->first();

        if (!$ruta) {
            abort(404);
        }

        \DB::table('tabla_ciclismo')
            ->where('ID_CICLISMO', $id)
            ->update([
                'NOMBRE_RUTA_CICLISMO' => $request->nombre_ruta_ciclismo ?? $ruta->NOMBRE_RUTA_CICLISMO,
                'ID_LOCALITIES' => $request->id_localities ?? $ruta->ID_LOCALITIES,
                'DESCRIPCION' => $request->descripcion ?? $ruta->DESCRIPCION
            ]);

        return response()->json(['message' => 'Ruta de ciclismo actualizada']);
    }

    public function destroy($id)
    {
        \DB::table('tabla_ciclismo')->where('ID_CICLISMO', $id)->delete();

        return response()->json(['message' => 'Ruta eliminada correctamente']);
    }
}
