<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\Playa;
use Illuminate\Http\Request;

class PlayaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 12);
            $page = $request->get('page', 1);

            $query = \DB::table('tabla_playas')
                ->leftJoin('tabla_localities as locality', 'tabla_playas.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_playas.ID_PLAYA',
                    'tabla_playas.NOMBRE_PLAYA',
                    'tabla_playas.DESCRIPCION',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                );

            $total = $query->count();
            $playas = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

            // Resolver imágenes en lote
            $playaNombres = $playas->pluck('NOMBRE_PLAYA')->toArray();
            $imagenes = \DB::table('tabla_imagenes')
                ->select('NOMBRE_IMAGEN', 'RUTA')
                ->get();

            $playas_con_imagenes = $playas->map(function($playa) use ($imagenes) {
                $nombreNormalizado = \App\Helpers\ImageHelper::cleanString($playa->NOMBRE_PLAYA);
                $imagen = $imagenes->first(function($img) use ($nombreNormalizado) {
                    return \App\Helpers\ImageHelper::cleanString($img->NOMBRE_IMAGEN) === $nombreNormalizado;
                });

                return (object)[
                    'id' => $playa->ID_PLAYA,
                    'nombre' => $playa->NOMBRE_PLAYA,
                    'descripcion' => $playa->DESCRIPCION,
                    'imagen' => $imagen ? $imagen->RUTA : null,
                    'locality_municipio' => $playa->locality_municipio,
                    'locality_departamento' => $playa->locality_departamento,
                    'locality_region' => $playa->locality_region,
                ];
            });

            return view('pages.playas', [
                'items' => $playas_con_imagenes,
                'total' => $total,
                'perPage' => $perPage,
                'page' => $page,
                'hasMore' => ($page * $perPage) < $total
            ]);
        } catch (\Exception $e) {
            return view('pages.playas', [
                'items' => collect([]),
                'error' => 'La tabla de playas no está disponible en este momento.'
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'locality_id' => 'required|integer',
            'country_id' => 'required|integer',
        ]);

        return Playa::create($request->all());
    }

    public function show($id)
    {
        try {
            $playa = \DB::table('tabla_playas')
                ->leftJoin('tabla_localities as locality', 'tabla_playas.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_playas.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->where('tabla_playas.ID_PLAYA', $id)
                ->first();

            if (!$playa) {
                abort(404);
            }

            $imagen = ImageHelper::getCategoriaImage('playas', $playa->NOMBRE_PLAYA);

            // Construir ubicación
            $ubicacion = 'Ubicación por confirmar';
            if (isset($playa->locality_municipio) && $playa->locality_municipio) {
                if (isset($playa->locality_departamento) && $playa->locality_departamento) {
                    $ubicacion = $playa->locality_municipio . ', ' . $playa->locality_departamento;
                } else {
                    $ubicacion = $playa->locality_municipio;
                }
            } elseif (isset($playa->locality_departamento) && $playa->locality_departamento) {
                $ubicacion = $playa->locality_departamento;
            }

            $item = (object)[
                'id' => $playa->ID_PLAYA,
                'nombre' => $playa->NOMBRE_PLAYA,
                'descripcion' => $playa->DESCRIPCION,
                'imagen' => $imagen,
                'ubicacion' => $ubicacion,
                'locality_municipio' => $playa->locality_municipio,
                'locality_departamento' => $playa->locality_departamento,
                'locality_region' => $playa->locality_region,
            ];

            return view('pages.detalle-playa', compact('item'))->with('tipo', 'Playa');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $playa = Playa::findOrFail($id);
        $playa->update($request->all());

        return $playa;
    }

    public function destroy($id)
    {
        Playa::findOrFail($id)->delete();
        return response()->json(['ok' => true]);
    }
}
