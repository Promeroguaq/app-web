<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class IslaController extends Controller
{
    public function index()
    {
        try {
            set_time_limit(120);

            $islas = \DB::table('tabla_islas')->limit(50)->get();

            \Log::info('Islas encontradas: ' . $islas->count());

            if ($islas->count() === 0) {
                return view('pages.islas', [
                    'items' => collect([]),
                    'error' => 'No hay islas registradas en la base de datos.'
                ]);
            }

            $islas_con_imagenes = $islas->map(function($isla) {
                $nombre = $isla->NOMBRE_ISLA ?? null;
                $descripcion = $isla->DESCRIPCION ?? null;
                $id = $isla->ID_ISLA ?? null;
                $departamento = $isla->DEPARTAMENTO ?? null;

                $imagen = ImageHelper::getCategoriaImage('islas', $nombre);
                $ubicacion = $departamento ? trim($departamento) : 'Ubicación por confirmar';

                return (object)[
                    'id' => $id,
                    'nombre' => $nombre ?? 'Sin nombre',
                    'descripcion' => $descripcion ?? 'Sin descripción disponible',
                    'imagen' => $imagen,
                    'localidad' => $ubicacion,
                    'departamento' => $departamento,
                ];
            });

            return view('pages.islas', ['items' => $islas_con_imagenes]);
        } catch (\Exception $e) {
            \Log::error('Error en IslaController: ' . $e->getMessage());
            return view('pages.islas', [
                'items' => collect([]),
                'error' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'departamento' => 'nullable|string',
            'descripcion' => 'nullable|string'
        ]);

        return \DB::table('tabla_islas')->insert([
            'NOMBRE_ISLA' => $request->nombre,
            'DEPARTAMENTO' => $request->departamento,
            'DESCRIPCION' => $request->descripcion
        ]);
    }

    public function show($id)
    {
        try {
            set_time_limit(60);

            $isla = \DB::table('tabla_islas')->where('ID_ISLA', $id)->first();

            if (!$isla) {
                abort(404);
            }

            $nombre = $isla->NOMBRE_ISLA ?? 'Sin nombre';
            $descripcion = $isla->DESCRIPCION ?? 'Sin descripción disponible';
            $imagen = ImageHelper::getCategoriaImage('islas', $nombre);
            $departamento = $isla->DEPARTAMENTO ?? null;
            $ubicacion = $departamento ? trim($departamento) : 'Ubicación por confirmar';

            $item = (object)[
                'id' => $isla->ID_ISLA,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'imagen' => $imagen,
                'ubicacion' => $ubicacion,
                'departamento' => $departamento,
            ];

            return view('pages.detalle-isla', compact('item'))->with('tipo', 'Isla');
        } catch (\Exception $e) {
            \Log::error('Error en IslaController show: ' . $e->getMessage());
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $isla = \DB::table('tabla_islas')->where('ID_ISLA', $id)->first();

        if (!$isla) {
            abort(404);
        }

        \DB::table('tabla_islas')
            ->where('ID_ISLA', $id)
            ->update([
                'NOMBRE_ISLA' => $request->nombre ?? $isla->NOMBRE_ISLA,
                'DEPARTAMENTO' => $request->departamento ?? $isla->DEPARTAMENTO,
                'DESCRIPCION' => $request->descripcion ?? $isla->DESCRIPCION
            ]);

        return response()->json(['message' => 'Isla actualizada']);
    }

    public function destroy($id)
    {
        \DB::table('tabla_islas')->where('ID_ISLA', $id)->delete();
        return response()->json(['message' => 'Isla eliminada']);
    }
}
