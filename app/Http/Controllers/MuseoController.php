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

                // Obtener nombre explícitamente
                $nombre = $museo->NOMBRE_MUSEO ?? null;

                // Obtener descripción explícitamente
                $descripcion = $museo->DESCRIPCION ?? null;

                // Obtener ID explícitamente (clave primaria real)
                $id = $museo->ID_MUSEO ?? null;

                $imagen = ImageHelper::getCategoriaImage('museos', $nombre);

                return (object)[
                    'id' => $id,
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

            // Buscar por clave primaria real: ID_MUSEO
            $museo = \DB::table('tabla_museos')
                ->leftJoin('tabla_localities as locality', 'tabla_museos.ID_LOCALITIES', '=', 'locality.ID')
                ->select(
                    'tabla_museos.*',
                    'locality.MUNICIPIOS as locality_municipio',
                    'locality.DEPARTAMENTO as locality_departamento',
                    'locality.REGION as locality_region'
                )
                ->where('ID_MUSEO', $id)
                ->first();

            if (!$museo) {
                abort(404);
            }

            // Obtener datos explícitamente
            $nombre = $museo->NOMBRE_MUSEO ?? 'Sin nombre';
            $descripcion = $museo->DESCRIPCION ?? 'Sin descripción disponible';
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
                'id' => $museo->ID_MUSEO,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'imagen' => $imagen,
                'ubicacion' => $ubicacion,
                'id_localities' => $museo->ID_LOCALITIES ?? null,
                'locality_municipio' => $museo->locality_municipio,
                'locality_departamento' => $museo->locality_departamento,
                'locality_region' => $museo->locality_region,
            ];

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
