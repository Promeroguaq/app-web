<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class ActividadParqueController extends Controller
{
    public function index()
    {
        try {
            set_time_limit(120);

            // Obtener actividades en parques con LEFT JOIN a tabla_localities
            // Nota: la columna es ID_LOCALITITES (con error tipográfico)
            $actividades = \DB::table('tabla_actividad_parque')
                ->leftJoin('tabla_localities as locality', 'tabla_actividad_parque.ID_LOCALITITES', '=', 'locality.ID')
                ->select(
                    'tabla_actividad_parque.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->limit(50)
                ->get();

            \Log::info('Actividades en parques encontradas: ' . $actividades->count());

            if ($actividades->count() === 0) {
                return view('pages.actividades-parques', [
                    'items' => collect([]),
                    'error' => 'No hay actividades en parques registradas en la base de datos.'
                ]);
            }

            $actividades_con_imagenes = $actividades->map(function($actividad) {
                $nombre = $actividad->NOMBRE_ACTIVIDAD_EN_PARQUE ?? null;
                $descripcion = $actividad->DESCRIPCION ?? null;
                $id = $actividad->ID_ACTIVIDAD ?? null;

                $imagen = ImageHelper::getCategoriaImage('actividades-parques', $nombre);

                // Construir ubicación
                $ubicacion = 'Ubicación por confirmar';
                if (isset($actividad->locality_municipio) && $actividad->locality_municipio) {
                    if (isset($actividad->locality_departamento) && $actividad->locality_departamento) {
                        $ubicacion = $actividad->locality_municipio . ', ' . $actividad->locality_departamento;
                    } else {
                        $ubicacion = $actividad->locality_municipio;
                    }
                } elseif (isset($actividad->locality_departamento) && $actividad->locality_departamento) {
                    $ubicacion = $actividad->locality_departamento;
                }

                return (object)[
                    'id' => $id,
                    'nombre' => $nombre ?? 'Sin nombre',
                    'descripcion' => $descripcion ?? 'Sin descripción disponible',
                    'imagen' => $imagen,
                    'localidad' => $ubicacion,
                    'locality_municipio' => $actividad->locality_municipio,
                    'locality_departamento' => $actividad->locality_departamento,
                    'locality_region' => $actividad->locality_region,
                ];
            });

            return view('pages.actividades-parques', ['items' => $actividades_con_imagenes]);
        } catch (\Exception $e) {
            \Log::error('Error en ActividadParqueController: ' . $e->getMessage());
            return view('pages.actividades-parques', [
                'items' => collect([]),
                'error' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try {
            set_time_limit(60);

            $actividad = \DB::table('tabla_actividad_parque')
                ->leftJoin('tabla_localities as locality', 'tabla_actividad_parque.ID_LOCALITITES', '=', 'locality.ID')
                ->select(
                    'tabla_actividad_parque.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->where('tabla_actividad_parque.ID_ACTIVIDAD', $id)
                ->first();

            if (!$actividad) {
                abort(404);
            }

            $nombre = $actividad->NOMBRE_ACTIVIDAD_EN_PARQUE ?? 'Sin nombre';
            $descripcion = $actividad->DESCRIPCION ?? 'Sin descripción disponible';
            $imagen = ImageHelper::getCategoriaImage('actividades-parques', $nombre);

            // Construir ubicación
            $ubicacion = 'Ubicación por confirmar';
            if (isset($actividad->locality_municipio) && $actividad->locality_municipio) {
                if (isset($actividad->locality_departamento) && $actividad->locality_departamento) {
                    $ubicacion = $actividad->locality_municipio . ', ' . $actividad->locality_departamento;
                } else {
                    $ubicacion = $actividad->locality_municipio;
                }
            } elseif (isset($actividad->locality_departamento) && $actividad->locality_departamento) {
                $ubicacion = $actividad->locality_departamento;
            }

            $item = (object)[
                'id' => $actividad->ID_ACTIVIDAD,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'imagen' => $imagen,
                'ubicacion' => $ubicacion,
                'locality_municipio' => $actividad->locality_municipio,
                'locality_departamento' => $actividad->locality_departamento,
                'locality_region' => $actividad->locality_region,
            ];

            return view('pages.detalle-actividad-parque', compact('item'))->with('tipo', 'Actividad en Parque');
        } catch (\Exception $e) {
            \Log::error('Error en ActividadParqueController show: ' . $e->getMessage());
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'id_localities' => 'required|exists:tabla_localities,ID',
            'descripcion' => 'nullable|string'
        ]);

        return \DB::table('tabla_actividad_parque')->insert([
            'NOMBRE_ACTIVIDAD_EN_PARQUE' => $request->nombre,
            'ID_LOCALITITES' => $request->id_localities,
            'DESCRIPCION' => $request->descripcion
        ]);
    }

    public function update(Request $request, $id)
    {
        $actividad = \DB::table('tabla_actividad_parque')->where('ID_ACTIVIDAD', $id)->first();

        if (!$actividad) {
            abort(404);
        }

        \DB::table('tabla_actividad_parque')
            ->where('ID_ACTIVIDAD', $id)
            ->update([
                'NOMBRE_ACTIVIDAD_EN_PARQUE' => $request->nombre ?? $actividad->NOMBRE_ACTIVIDAD_EN_PARQUE,
                'ID_LOCALITITES' => $request->id_localities ?? $actividad->ID_LOCALITITES,
                'DESCRIPCION' => $request->descripcion ?? $actividad->DESCRIPCION
            ]);

        return response()->json(['message' => 'Actividad actualizada']);
    }

    public function destroy($id)
    {
        \DB::table('tabla_actividad_parque')->where('ID_ACTIVIDAD', $id)->delete();

        return response()->json(['message' => 'Actividad eliminada']);
    }
}
