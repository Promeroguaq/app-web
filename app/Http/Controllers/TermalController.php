<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class TermalController extends Controller
{
    public function index()
    {
        try {
            set_time_limit(120);

            // Obtener termales con LEFT JOIN a tabla_localities
            $termales = \DB::table('tabla_termales')
                ->leftJoin('tabla_localities as locality', 'tabla_termales.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_termales.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->limit(50)
                ->get();

            \Log::info('Termales encontrados: ' . $termales->count());

            if ($termales->count() === 0) {
                return view('pages.termales', [
                    'items' => collect([]),
                    'error' => 'No hay termales registrados en la base de datos.'
                ]);
            }

            $termales_con_imagenes = $termales->map(function($termal) {
                $nombre = $termal->NOMBRE_TERMAL ?? null;
                $descripcion = $termal->DESCRIPCION ?? null;
                $id = $termal->ID_TERMALES ?? null;

                $imagen = ImageHelper::getCategoriaImage('termales', $nombre);

                // Construir ubicación
                $ubicacion = 'Ubicación por confirmar';
                if (isset($termal->locality_municipio) && $termal->locality_municipio) {
                    if (isset($termal->locality_departamento) && $termal->locality_departamento) {
                        $ubicacion = $termal->locality_municipio . ', ' . $termal->locality_departamento;
                    } else {
                        $ubicacion = $termal->locality_municipio;
                    }
                } elseif (isset($termal->locality_departamento) && $termal->locality_departamento) {
                    $ubicacion = $termal->locality_departamento;
                }

                return (object)[
                    'id' => $id,
                    'nombre' => $nombre ?? 'Sin nombre',
                    'descripcion' => $descripcion ?? 'Sin descripción disponible',
                    'imagen' => $imagen,
                    'localidad' => $ubicacion,
                    'locality_municipio' => $termal->locality_municipio,
                    'locality_departamento' => $termal->locality_departamento,
                    'locality_region' => $termal->locality_region,
                ];
            });

            return view('pages.termales', ['items' => $termales_con_imagenes]);
        } catch (\Exception $e) {
            \Log::error('Error en TermalController: ' . $e->getMessage());
            return view('pages.termales', [
                'items' => collect([]),
                'error' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try {
            set_time_limit(60);

            $termal = \DB::table('tabla_termales')
                ->leftJoin('tabla_localities as locality', 'tabla_termales.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_termales.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->where('tabla_termales.ID_TERMALES', $id)
                ->first();

            if (!$termal) {
                abort(404);
            }

            $nombre = $termal->NOMBRE_TERMAL ?? 'Sin nombre';
            $descripcion = $termal->DESCRIPCION ?? 'Sin descripción disponible';
            $imagen = ImageHelper::getCategoriaImage('termales', $nombre);

            // Construir ubicación
            $ubicacion = 'Ubicación por confirmar';
            if (isset($termal->locality_municipio) && $termal->locality_municipio) {
                if (isset($termal->locality_departamento) && $termal->locality_departamento) {
                    $ubicacion = $termal->locality_municipio . ', ' . $termal->locality_departamento;
                } else {
                    $ubicacion = $termal->locality_municipio;
                }
            } elseif (isset($termal->locality_departamento) && $termal->locality_departamento) {
                $ubicacion = $termal->locality_departamento;
            }

            $item = (object)[
                'id' => $termal->ID_TERMALES,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'imagen' => $imagen,
                'ubicacion' => $ubicacion,
                'locality_municipio' => $termal->locality_municipio,
                'locality_departamento' => $termal->locality_departamento,
                'locality_region' => $termal->locality_region,
            ];

            return view('pages.detalle-termal', compact('item'))->with('tipo', 'Termal');
        } catch (\Exception $e) {
            \Log::error('Error en TermalController show: ' . $e->getMessage());
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

        return \DB::table('tabla_termales')->insert([
            'NOMBRE_TERMAL' => $request->nombre,
            'ID_LOCALITIES' => $request->id_localities,
            'DESCRIPCION' => $request->descripcion
        ]);
    }

    public function update(Request $request, $id)
    {
        $termal = \DB::table('tabla_termales')->where('ID_TERMALES', $id)->first();

        if (!$termal) {
            abort(404);
        }

        \DB::table('tabla_termales')
            ->where('ID_TERMALES', $id)
            ->update([
                'NOMBRE_TERMAL' => $request->nombre ?? $termal->NOMBRE_TERMAL,
                'ID_LOCALITIES' => $request->id_localities ?? $termal->ID_LOCALITIES,
                'DESCRIPCION' => $request->descripcion ?? $termal->DESCRIPCION
            ]);

        return response()->json(['message' => 'Termal actualizado']);
    }

    public function destroy($id)
    {
        \DB::table('tabla_termales')->where('ID_TERMALES', $id)->delete();

        return response()->json(['message' => 'Eliminado correctamente']);
    }
}
