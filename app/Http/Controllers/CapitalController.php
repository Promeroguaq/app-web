<?php

namespace App\Http\Controllers;

use App\Models\Capital;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CapitalController extends Controller
{
    public function index()
    {
        try {
            // Get all capitals from tabla_capitales with location data from tabla_localities
            $capitales = DB::table('tabla_capitales as capital')
                ->leftJoin('tabla_localities as locality', 'capital.NOMBRE_CAPITAL', '=', 'locality.MUNICIPIOS')
                ->select(
                    'capital.ID_CAPITAL',
                    'capital.NOMBRE_CAPITAL',
                    'capital.DESCRIPCION',
                    'locality.DEPARTAMENTO as departamento',
                    'locality.REGION as region'
                )
                ->get();

            // Load images from tabla_imagenes - CACHED
            $imagenes = Cache::remember('imagenes_map_global', 1800, function () {
                return DB::table('tabla_imagenes')->get();
            });
            $imagenesPorNombre = $imagenes->keyBy(function($img) {
                return \App\Helpers\ImageHelper::cleanString($img->NOMBRE_IMAGEN);
            });

            // Map capitals with slugs, images, and location data
            $capitalesConImagen = $capitales->map(function($capital) use ($imagenesPorNombre) {
                $nombre = trim($capital->NOMBRE_CAPITAL);
                $nombreNormalizado = \App\Helpers\ImageHelper::cleanString($nombre);
                $slug = Str::slug($nombre);

                // Try to find image
                $imagenUrl = null;
                if (isset($imagenesPorNombre[$nombreNormalizado])) {
                    $imagenUrl = $imagenesPorNombre[$nombreNormalizado]->RUTA;
                }

                // Fallback description if empty
                $descripcion = $capital->DESCRIPCION;
                if (empty($descripcion)) {
                    $descripcion = 'Información turística en actualización.';
                }

                return (object)[
                    'id' => $capital->ID_CAPITAL,
                    'nombre' => $nombre,
                    'slug' => $slug,
                    'descripcion' => $descripcion,
                    'departamento' => $capital->departamento,
                    'region' => $capital->region,
                    'imagen' => $imagenUrl,
                ];
            });

            return view('pages.capitales', ['items' => $capitalesConImagen]);
        } catch (\Exception $e) {
            Log::error('Error loading capitales: ' . $e->getMessage());
            return view('pages.capitales', ['items' => collect([]), 'error' => 'Error al cargar capitales']);
        }
    }

    public function show($slug)
    {
        try {
            // Find capital by slug with location data
            $capital = DB::table('tabla_capitales as capital')
                ->leftJoin('tabla_localities as locality', 'capital.NOMBRE_CAPITAL', '=', 'locality.MUNICIPIOS')
                ->select(
                    'capital.ID_CAPITAL',
                    'capital.NOMBRE_CAPITAL',
                    'capital.DESCRIPCION',
                    'locality.DEPARTAMENTO as departamento',
                    'locality.REGION as region'
                )
                ->get()
                ->first(function($cap) use ($slug) {
                    return Str::slug($cap->NOMBRE_CAPITAL) === $slug;
                });

            if (!$capital) {
                abort(404);
            }

            // Get image
            $imagenes = DB::table('tabla_imagenes')->get();
            $imagenesPorNombre = $imagenes->keyBy(function($img) {
                return \App\Helpers\ImageHelper::cleanString($img->NOMBRE_IMAGEN);
            });

            $nombre = trim($capital->NOMBRE_CAPITAL);
            $nombreNormalizado = \App\Helpers\ImageHelper::cleanString($nombre);
            $imagenUrl = null;

            if (isset($imagenesPorNombre[$nombreNormalizado])) {
                $imagenUrl = $imagenesPorNombre[$nombreNormalizado]->RUTA;
            }

            // Fallback description if empty
            $descripcion = $capital->DESCRIPCION;
            if (empty($descripcion)) {
                $descripcion = 'Información turística en actualización.';
            }

            $item = (object)[
                'id' => $capital->ID_CAPITAL,
                'nombre' => $nombre,
                'slug' => $slug,
                'descripcion' => $descripcion,
                'departamento' => $capital->departamento,
                'region' => $capital->region,
                'imagen' => $imagenUrl,
            ];

            return view('pages.detalle-capital', compact('item'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
