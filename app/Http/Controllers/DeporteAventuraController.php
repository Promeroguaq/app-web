<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class DeporteAventuraController extends Controller
{
    public function index()
    {
        try {
            // Get adventure sports from database
            // Note: this table does NOT have ID_LOCALITIES, it has MUNICIPIOS as text
            $deportes = \DB::table('tabla_deporte_aventura')
                ->get();

            \Log::info('Deportes de aventura encontrados: ' . $deportes->count());

            // Map data for view
            $deportes_con_imagenes = $deportes->map(function($deporte) {
                $nombre = $deporte->NOMBRE_DEPORTE_AVENTURA ?? null;
                $descripcion = $deporte->DESCRIPCION ?? null;
                $id = $deporte->ID_DEPORTES ?? null;
                $municipios = $deporte->MUNICIPIOS ?? null;

                $imagen = \App\Helpers\ImageHelper::getCategoriaImage('deportes-aventura', $nombre);

                // MUNICIPIOS contains text like "Roldanillo (Valle), Piedecuesta (Santander)..."
                // Use this text as location
                $ubicacion = $municipios ? trim($municipios) : 'Colombia';

                return (object)[
                    'id' => $id,
                    'nombre' => $nombre ?? 'Sin nombre',
                    'descripcion' => $descripcion ?? 'Sin descripción disponible',
                    'imagen' => $imagen,
                    'localidad' => $ubicacion,
                    'municipios' => $municipios,
                ];
            });

            // Calculate statistics
            $total = $deportes->count();
            $destinosCount = $deportes->pluck('MUNICIPIOS')->filter()->unique()->count();
            $perPage = $total; // Show all items since there's no pagination
            $page = 1;

            return view('pages.deportes-aventura', [
                'items' => $deportes_con_imagenes,
                'total' => $total,
                'perPage' => $perPage,
                'page' => $page,
                'destinosCount' => $destinosCount
            ]);
        } catch (\Exception $e) {
            \Log::error('Error en DeporteAventuraController: ' . $e->getMessage());
            return view('pages.deportes-aventura', [
                'items' => collect([]),
                'total' => 0,
                'perPage' => 0,
                'page' => 1,
                'destinosCount' => 0,
                'error' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try {
            $deporte = \DB::table('tabla_deporte_aventura')
                ->where('ID_DEPORTES', $id)
                ->first();

            if (!$deporte) {
                abort(404);
            }

            $nombre = $deporte->NOMBRE_DEPORTE_AVENTURA ?? 'Sin nombre';
            $descripcion = $deporte->DESCRIPCION ?? 'Sin descripción disponible';
            $imagen = \App\Helpers\ImageHelper::getCategoriaImage('deportes-aventura', $nombre);
            $municipios = $deporte->MUNICIPIOS ?? null;

            $ubicacion = $municipios ? trim($municipios) : 'Colombia';

            $item = (object)[
                'id' => $deporte->ID_DEPORTES,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'imagen' => $imagen,
                'ubicacion' => $ubicacion,
                'municipios' => $municipios,
            ];

            return view('pages.detalle-deporte-aventura', compact('item'))->with('tipo', 'Deporte de Aventura');
        } catch (\Exception $e) {
            \Log::error('Error en DeporteAventuraController show: ' . $e->getMessage());
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'municipios' => 'nullable|string',
            'descripcion' => 'nullable|string'
        ]);

        return \DB::table('tabla_deporte_aventura')->insert([
            'NOMBRE_DEPORTE_AVENTURA' => $request->nombre,
            'MUNICIPIOS' => $request->municipios,
            'DESCRIPCION' => $request->descripcion
        ]);
    }

    public function update(Request $request, $id)
    {
        $deporte = \DB::table('tabla_deporte_aventura')->where('ID_DEPORTES', $id)->first();

        if (!$deporte) {
            abort(404);
        }

        \DB::table('tabla_deporte_aventura')
            ->where('ID_DEPORTES', $id)
            ->update([
                'NOMBRE_DEPORTE_AVENTURA' => $request->nombre ?? $deporte->NOMBRE_DEPORTE_AVENTURA,
                'MUNICIPIOS' => $request->municipios ?? $deporte->MUNICIPIOS,
                'DESCRIPCION' => $request->descripcion ?? $deporte->DESCRIPCION
            ]);

        return response()->json(['message' => 'Deporte de aventura actualizado']);
    }

    public function destroy($id)
    {
        \DB::table('tabla_deporte_aventura')->where('ID_DEPORTES', $id)->delete();

        return response()->json(['message' => 'Eliminado correctamente']);
    }
}
