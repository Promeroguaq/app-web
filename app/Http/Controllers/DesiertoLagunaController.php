<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class DesiertoLagunaController extends Controller
{
    public function index()
    {
        try {
            set_time_limit(120);

            // Obtener desiertos y lagunas con LEFT JOIN a tabla_localities
            $items = \DB::table('tabla_desierto_laguna')
                ->leftJoin('tabla_localities as locality', 'tabla_desierto_laguna.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_desierto_laguna.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->limit(50)
                ->get();

            \Log::info('Desiertos y lagunas encontrados: ' . $items->count());

            if ($items->count() === 0) {
                return view('pages.desiertos-lagunas', [
                    'items' => collect([]),
                    'error' => 'No hay desiertos o lagunas registrados en la base de datos.'
                ]);
            }

            $items_con_imagenes = $items->map(function($item) {
                $nombre = $item->NOMBRE_DESIERTO_LAGUNAS ?? null;
                $descripcion = $item->DESCRIPCION ?? null;
                $id = $item->ID_DESIERTO ?? null;

                $imagen = ImageHelper::getCategoriaImage('desiertos-lagunas', $nombre);

                // Construir ubicación
                $ubicacion = 'Ubicación por confirmar';
                if (isset($item->locality_municipio) && $item->locality_municipio) {
                    if (isset($item->locality_departamento) && $item->locality_departamento) {
                        $ubicacion = $item->locality_municipio . ', ' . $item->locality_departamento;
                    } else {
                        $ubicacion = $item->locality_municipio;
                    }
                } elseif (isset($item->locality_departamento) && $item->locality_departamento) {
                    $ubicacion = $item->locality_departamento;
                }

                return (object)[
                    'id' => $id,
                    'nombre' => $nombre ?? 'Sin nombre',
                    'descripcion' => $descripcion ?? 'Sin descripción disponible',
                    'imagen' => $imagen,
                    'localidad' => $ubicacion,
                    'locality_municipio' => $item->locality_municipio,
                    'locality_departamento' => $item->locality_departamento,
                    'locality_region' => $item->locality_region,
                ];
            });

            return view('pages.desiertos-lagunas', ['items' => $items_con_imagenes]);
        } catch (\Exception $e) {
            \Log::error('Error en DesiertoLagunaController: ' . $e->getMessage());
            return view('pages.desiertos-lagunas', [
                'items' => collect([]),
                'error' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try {
            set_time_limit(60);

            $item = \DB::table('tabla_desierto_laguna')
                ->leftJoin('tabla_localities as locality', 'tabla_desierto_laguna.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_desierto_laguna.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->where('tabla_desierto_laguna.ID_DESIERTO', $id)
                ->first();

            if (!$item) {
                abort(404);
            }

            $nombre = $item->NOMBRE_DESIERTO_LAGUNAS ?? 'Sin nombre';
            $descripcion = $item->DESCRIPCION ?? 'Sin descripción disponible';
            $imagen = ImageHelper::getCategoriaImage('desiertos-lagunas', $nombre);

            // Construir ubicación
            $ubicacion = 'Ubicación por confirmar';
            if (isset($item->locality_municipio) && $item->locality_municipio) {
                if (isset($item->locality_departamento) && $item->locality_departamento) {
                    $ubicacion = $item->locality_municipio . ', ' . $item->locality_departamento;
                } else {
                    $ubicacion = $item->locality_municipio;
                }
            } elseif (isset($item->locality_departamento) && $item->locality_departamento) {
                $ubicacion = $item->locality_departamento;
            }

            $item = (object)[
                'id' => $item->ID_DESIERTO,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'imagen' => $imagen,
                'localidad' => $item->locality_municipio ?? null,
                'departamento' => $item->locality_departamento ?? null,
                'region' => $item->locality_region ?? null,
            ];

            return view('pages.detalle-desierto-laguna', compact('item'))->with('tipo', 'Desierto/Laguna');
        } catch (\Exception $e) {
            \Log::error('Error en DesiertoLagunaController show: ' . $e->getMessage());
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

        return \DB::table('tabla_desierto_laguna')->insert([
            'NOMBRE_DESIERTO_LAGUNAS' => $request->nombre,
            'ID_LOCALITIES' => $request->id_localities,
            'DESCRIPCION' => $request->descripcion
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = \DB::table('tabla_desierto_laguna')->where('ID_DESIERTO', $id)->first();

        if (!$item) {
            abort(404);
        }

        \DB::table('tabla_desierto_laguna')
            ->where('ID_DESIERTO', $id)
            ->update([
                'NOMBRE_DESIERTO_LAGUNAS' => $request->nombre ?? $item->NOMBRE_DESIERTO_LAGUNAS,
                'ID_LOCALITIES' => $request->id_localities ?? $item->ID_LOCALITIES,
                'DESCRIPCION' => $request->descripcion ?? $item->DESCRIPCION
            ]);

        return response()->json(['message' => 'Registro actualizado']);
    }

    public function destroy($id)
    {
        \DB::table('tabla_desierto_laguna')->where('ID_DESIERTO', $id)->delete();

        return response()->json(['message' => 'Registro eliminado']);
    }
}
