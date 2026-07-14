<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\Museo;
use Illuminate\Http\Request;

class MuseoController extends Controller
{
    // Listar todos los museos
    public function index()
    {
        \Log::info('Iniciando MuseoController index');

        try {
            set_time_limit(120);

            // Obtener museos con LEFT JOIN a tabla_localities
            $museos = \DB::table('tabla_museos')
                ->leftJoin('tabla_localities as locality', 'tabla_museos.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_museos.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->limit(50)
                ->get();

            \Log::info('Museos encontrados: ' . $museos->count());

            if ($museos->count() === 0) {
                \Log::error('La tabla tabla_museos está vacía o no existe');
                return view('pages.museos', [
                    'items' => collect([]),
                    'error' => 'No hay museos registrados en la base de datos.'
                ]);
            }

            if ($museos->count() > 0) {
                $primerMuseo = $museos->first();
                \Log::info('Primer museo: ' . json_encode($primerMuseo));
                \Log::info('Columnas: ' . json_encode(array_keys((array)$primerMuseo)));
            }

            $museos_con_imagenes = $museos->map(function($museo) {
                $columnas = array_keys((array)$museo);

                // Intentar obtener nombre
                $nombre = null;
                foreach ($columnas as $col) {
                    if (stripos($col, 'nombre') !== false) {
                        $nombre = $museo->$col;
                        break;
                    }
                }

                // Intentar obtener descripción
                $descripcion = null;
                foreach ($columnas as $col) {
                    if (stripos($col, 'desc') !== false) {
                        $descripcion = $museo->$col;
                        break;
                    }
                }

                // Intentar obtener ID
                $id = null;
                foreach ($columnas as $col) {
                    if (stripos($col, 'id') !== false && $col !== 'id_localities' && $col !== 'id_country') {
                        $id = $museo->$col;
                        break;
                    }
                }

                $imagen = ImageHelper::getCategoriaImage('museos', $nombre);

                return (object)[
                    'id' => $id ?? $museo->{'COL 1'} ?? null,
                    'nombre' => $nombre ?? 'Sin nombre',
                    'descripcion' => $descripcion ?? 'Sin descripción disponible',
                    'imagen' => $imagen,
                    'locality_municipio' => $museo->locality_municipio,
                    'locality_departamento' => $museo->locality_departamento,
                    'locality_region' => $museo->locality_region,
                ];
            });

            \Log::info('Museos procesados exitosamente');
            return view('pages.museos', ['items' => $museos_con_imagenes]);
        } catch (\Exception $e) {
            \Log::error('Error en MuseoController: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return view('pages.museos', [
                'items' => collect([]),
                'error' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    // Guardar museo
    public function store(Request $request)
    {
        $request->validate([
            'nombre_museo'   => 'required|string|max:255',
            'id_localities'  => 'required|integer',
            'descripcion'    => 'nullable|string',
            'id_country'     => 'required|integer',
        ]);

        return Museo::create($request->all());
    }

    // Mostrar un museo
    public function show($id)
    {
        try {
            set_time_limit(60);

            // Buscar por TODAS las columnas que puedan ser ID (misma lógica que index)
            $museo = \DB::table('tabla_museos')
                ->leftJoin('tabla_localities as locality', 'tabla_museos.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_museos.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->where(function($query) use ($id) {
                    // Intentar buscar por COL 1
                    $query->where('COL 1', $id);
                    // También intentar por cualquier columna que contenga 'id' (excepto id_localities, id_country)
                    $query->orWhere(function($q) use ($id) {
                        $q->where('ID_MUSEO', $id);
                    });
                })
                ->first();

            if (!$museo) {
                abort(404);
            }

            // Obtener todas las columnas disponibles
            $columnas = array_keys((array)$museo);
            \Log::info('Columnas del museo en show: ' . json_encode($columnas));

            // Obtener nombre dinámicamente
            $nombre = null;
            foreach ($columnas as $col) {
                if (stripos($col, 'nombre') !== false) {
                    $nombre = $museo->$col;
                    break;
                }
            }

            // Obtener descripción dinámicamente
            $descripcion = null;
            foreach ($columnas as $col) {
                if (stripos($col, 'desc') !== false) {
                    $descripcion = $museo->$col;
                    break;
                }
            }

            // Obtener ID dinámicamente (misma lógica que index)
            $id_real = null;
            foreach ($columnas as $col) {
                if (stripos($col, 'id') !== false && $col !== 'id_localities' && $col !== 'id_country') {
                    $id_real = $museo->$col;
                    break;
                }
            }

            $imagen = ImageHelper::getCategoriaImage('museos', $nombre);

            // Obtener ubicación desde tabla_localities
            $ubicacion = 'Ubicación por confirmar';
            if (isset($museo->locality_municipio) && $museo->locality_municipio) {
                if (isset($museo->locality_departamento) && $museo->locality_departamento) {
                    $ubicacion = $museo->locality_municipio . ', ' . $museo->locality_departamento;
                } else {
                    $ubicacion = $museo->locality_municipio;
                }
            } elseif (isset($museo->locality_departamento) && $museo->locality_departamento) {
                $ubicacion = $museo->locality_departamento;
            }

            // Crear objeto con todos los datos del museo
            $item = (object)[
                'id' => $id_real ?? $museo->{'COL 1'} ?? null,
                'nombre' => $nombre ?? 'Sin nombre',
                'descripcion' => $descripcion ?? 'Sin descripción disponible',
                'imagen' => $imagen,
                'ubicacion' => $ubicacion,
                'id_localities' => $museo->ID_LOCALITIES ?? null
            ];

            // Agregar todas las demás columnas disponibles
            foreach ($columnas as $col) {
                if (!isset($item->$col) && $col !== 'COL 1') {
                    $item->$col = $museo->$col;
                }
            }

            return view('pages.detalle-museo', compact('item'))->with('tipo', 'Museo');
        } catch (\Exception $e) {
            \Log::error('Error en MuseoController show: ' . $e->getMessage());
            abort(404);
        }
    }

    // Actualizar museo
    public function update(Request $request, $id)
    {
        $museo = Museo::findOrFail($id);
        $museo->update($request->all());

        return $museo;
    }

    // Eliminar museo
    public function destroy($id)
    {
        Museo::destroy($id);
        return response()->json(['message' => 'Museo eliminado']);
    }
}
