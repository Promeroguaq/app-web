<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class ParqueTematicoController extends Controller
{
    public function index()
    {
        try {
            set_time_limit(120);

            // Obtener parques temáticos con LEFT JOIN a tabla_localities
            $parques = \DB::table('tabla_parque_tematicos')
                ->leftJoin('tabla_localities as locality', 'tabla_parque_tematicos.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_parque_tematicos.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->limit(50)
                ->get();

            \Log::info('Parques temáticos encontrados: ' . $parques->count());

            if ($parques->count() === 0) {
                return view('pages.parques-tematicos', [
                    'items' => collect([]),
                    'error' => 'No hay parques temáticos registrados en la base de datos.'
                ]);
            }

            $parques_con_imagenes = $parques->map(function($parque) {
                $nombre = $parque->NOMBRE_PARQUES_TEMÁTICOS ?? null;
                $descripcion = $parque->DESCRIPCION ?? null;
                $id = $parque->ID_PARQUES ?? null;

                $imagen = ImageHelper::getCategoriaImage('parques-tematicos', $nombre);

                // Construir ubicación
                $ubicacion = 'Ubicación por confirmar';
                if (isset($parque->locality_municipio) && $parque->locality_municipio) {
                    if (isset($parque->locality_departamento) && $parque->locality_departamento) {
                        $ubicacion = $parque->locality_municipio . ', ' . $parque->locality_departamento;
                    } else {
                        $ubicacion = $parque->locality_municipio;
                    }
                } elseif (isset($parque->locality_departamento) && $parque->locality_departamento) {
                    $ubicacion = $parque->locality_departamento;
                }

                return (object)[
                    'id' => $id,
                    'nombre' => $nombre ?? 'Sin nombre',
                    'descripcion' => $descripcion ?? 'Sin descripción disponible',
                    'imagen' => $imagen,
                    'localidad' => $ubicacion,
                    'locality_municipio' => $parque->locality_municipio,
                    'locality_departamento' => $parque->locality_departamento,
                    'locality_region' => $parque->locality_region,
                ];
            });

            return view('pages.parques-tematicos', ['items' => $parques_con_imagenes]);
        } catch (\Exception $e) {
            \Log::error('Error en ParqueTematicoController: ' . $e->getMessage());
            return view('pages.parques-tematicos', [
                'items' => collect([]),
                'error' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try {
            set_time_limit(60);

            $parque = \DB::table('tabla_parque_tematicos')
                ->leftJoin('tabla_localities as locality', 'tabla_parque_tematicos.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_parque_tematicos.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->where('tabla_parque_tematicos.ID_PARQUES', $id)
                ->first();

            if (!$parque) {
                abort(404);
            }

            $nombre = $parque->NOMBRE_PARQUES_TEMÁTICOS ?? 'Sin nombre';
            $descripcion = $parque->DESCRIPCION ?? 'Sin descripción disponible';
            $imagen = ImageHelper::getCategoriaImage('parques-tematicos', $nombre);

            // Construir ubicación
            $ubicacion = 'Ubicación por confirmar';
            if (isset($parque->locality_municipio) && $parque->locality_municipio) {
                if (isset($parque->locality_departamento) && $parque->locality_departamento) {
                    $ubicacion = $parque->locality_municipio . ', ' . $parque->locality_departamento;
                } else {
                    $ubicacion = $parque->locality_municipio;
                }
            } elseif (isset($parque->locality_departamento) && $parque->locality_departamento) {
                $ubicacion = $parque->locality_departamento;
            }

            $item = (object)[
                'id' => $parque->ID_PARQUES,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'imagen' => $imagen,
                'ubicacion' => $ubicacion,
                'locality_municipio' => $parque->locality_municipio,
                'locality_departamento' => $parque->locality_departamento,
                'locality_region' => $parque->locality_region,
            ];

            return view('pages.detalle-parque-tematico', compact('item'))->with('tipo', 'Parque Temático');
        } catch (\Exception $e) {
            \Log::error('Error en ParqueTematicoController show: ' . $e->getMessage());
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

        return \DB::table('tabla_parque_tematicos')->insert([
            'NOMBRE_PARQUES_TEMÁTICOS' => $request->nombre,
            'ID_LOCALITIES' => $request->id_localities,
            'DESCRIPCION' => $request->descripcion
        ]);
    }

    public function update(Request $request, $id)
    {
        $parque = \DB::table('tabla_parque_tematicos')->where('ID_PARQUES', $id)->first();

        if (!$parque) {
            abort(404);
        }

        \DB::table('tabla_parque_tematicos')
            ->where('ID_PARQUES', $id)
            ->update([
                'NOMBRE_PARQUES_TEMÁTICOS' => $request->nombre ?? $parque->NOMBRE_PARQUES_TEMÁTICOS,
                'ID_LOCALITIES' => $request->id_localities ?? $parque->ID_LOCALITIES,
                'DESCRIPCION' => $request->descripcion ?? $parque->DESCRIPCION
            ]);

        return response()->json(['message' => 'Parque temático actualizado']);
    }

    public function destroy($id)
    {
        \DB::table('tabla_parque_tematicos')->where('ID_PARQUES', $id)->delete();

        return response()->json(['message' => 'Parque temático eliminado']);
    }
}
