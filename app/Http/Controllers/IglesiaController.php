<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class IglesiaController extends Controller
{
    public function index()
    {
        try {
            set_time_limit(120);

            // Obtener iglesias con LEFT JOIN a tabla_localities
            $iglesias = \DB::table('tabla_iglesias')
                ->leftJoin('tabla_localities as locality', 'tabla_iglesias.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_iglesias.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->limit(50)
                ->get();

            \Log::info('Iglesias encontradas: ' . $iglesias->count());

            if ($iglesias->count() === 0) {
                return view('pages.iglesias', [
                    'items' => collect([]),
                    'error' => 'No hay iglesias registradas en la base de datos.'
                ]);
            }

            $iglesias_con_imagenes = $iglesias->map(function($iglesia) {
                $nombre = $iglesia->NOMBRE_IGLESIA ?? null;
                $descripcion = $iglesia->DESCRIPCION ?? null;
                $id = $iglesia->ID_IGLESIA ?? null;

                $imagen = ImageHelper::getCategoriaImage('iglesias', $nombre);

                // Construir ubicación
                $ubicacion = 'Ubicación por confirmar';
                if (isset($iglesia->locality_municipio) && $iglesia->locality_municipio) {
                    if (isset($iglesia->locality_departamento) && $iglesia->locality_departamento) {
                        $ubicacion = $iglesia->locality_municipio . ', ' . $iglesia->locality_departamento;
                    } else {
                        $ubicacion = $iglesia->locality_municipio;
                    }
                } elseif (isset($iglesia->locality_departamento) && $iglesia->locality_departamento) {
                    $ubicacion = $iglesia->locality_departamento;
                }

                return (object)[
                    'id' => $id,
                    'nombre' => $nombre ?? 'Sin nombre',
                    'descripcion' => $descripcion ?? 'Sin descripción disponible',
                    'imagen' => $imagen,
                    'localidad' => $ubicacion,
                    'locality_municipio' => $iglesia->locality_municipio,
                    'locality_departamento' => $iglesia->locality_departamento,
                    'locality_region' => $iglesia->locality_region,
                ];
            });

            return view('pages.iglesias', ['items' => $iglesias_con_imagenes]);
        } catch (\Exception $e) {
            \Log::error('Error en IglesiaController: ' . $e->getMessage());
            return view('pages.iglesias', [
                'items' => collect([]),
                'error' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try {
            set_time_limit(60);

            $iglesia = \DB::table('tabla_iglesias')
                ->leftJoin('tabla_localities as locality', 'tabla_iglesias.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_iglesias.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->where('tabla_iglesias.ID_IGLESIA', $id)
                ->first();

            if (!$iglesia) {
                abort(404);
            }

            $nombre = $iglesia->NOMBRE_IGLESIA ?? 'Sin nombre';
            $descripcion = $iglesia->DESCRIPCION ?? 'Sin descripción disponible';
            $imagen = ImageHelper::getCategoriaImage('iglesias', $nombre);

            // Construir ubicación
            $ubicacion = 'Ubicación por confirmar';
            if (isset($iglesia->locality_municipio) && $iglesia->locality_municipio) {
                if (isset($iglesia->locality_departamento) && $iglesia->locality_departamento) {
                    $ubicacion = $iglesia->locality_municipio . ', ' . $iglesia->locality_departamento;
                } else {
                    $ubicacion = $iglesia->locality_municipio;
                }
            } elseif (isset($iglesia->locality_departamento) && $iglesia->locality_departamento) {
                $ubicacion = $iglesia->locality_departamento;
            }

            $item = (object)[
                'id' => $iglesia->ID_IGLESIA,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'imagen' => $imagen,
                'ubicacion' => $ubicacion,
                'locality_municipio' => $iglesia->locality_municipio,
                'locality_departamento' => $iglesia->locality_departamento,
                'locality_region' => $iglesia->locality_region,
            ];

            return view('pages.detalle-iglesia', compact('item'))->with('tipo', 'Iglesia');
        } catch (\Exception $e) {
            \Log::error('Error en IglesiaController show: ' . $e->getMessage());
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_iglesia' => 'required|string',
            'id_localities'  => 'required|exists:tabla_localities,ID',
            'descripcion'    => 'nullable|string'
        ]);

        return \DB::table('tabla_iglesias')->insert([
            'NOMBRE_IGLESIA' => $request->nombre_iglesia,
            'ID_LOCALITIES' => $request->id_localities,
            'DESCRIPCION' => $request->descripcion
        ]);
    }

    public function update(Request $request, $id)
    {
        $iglesia = \DB::table('tabla_iglesias')->where('ID_IGLESIA', $id)->first();

        if (!$iglesia) {
            abort(404);
        }

        \DB::table('tabla_iglesias')
            ->where('ID_IGLESIA', $id)
            ->update([
                'NOMBRE_IGLESIA' => $request->nombre_iglesia ?? $iglesia->NOMBRE_IGLESIA,
                'ID_LOCALITIES' => $request->id_localities ?? $iglesia->ID_LOCALITIES,
                'DESCRIPCION' => $request->descripcion ?? $iglesia->DESCRIPCION
            ]);

        return response()->json(['message' => 'Iglesia actualizada']);
    }

    public function destroy($id)
    {
        \DB::table('tabla_iglesias')->where('ID_IGLESIA', $id)->delete();

        return response()->json(['message' => 'Iglesia eliminada']);
    }
}
