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
            // Get all capitals from tabla_capitales
            $capitales = DB::table('tabla_capitales')->get();

            // Load images from tabla_imagenes - CACHED
            $imagenes = Cache::remember('imagenes_map_global', 1800, function () {
                return DB::table('tabla_imagenes')->get();
            });
            $imagenesPorNombre = $imagenes->keyBy(function($img) {
                return \App\Helpers\ImageHelper::cleanString($img->NOMBRE_IMAGEN);
            });

            // Map capitals with slugs and images
            $capitalesConImagen = $capitales->map(function($capital) use ($imagenesPorNombre) {
                $nombre = trim($capital->NOMBRE_CAPITAL);
                $nombreNormalizado = \App\Helpers\ImageHelper::cleanString($nombre);
                $slug = Str::slug($nombre);

                // Try to find image
                $imagenUrl = null;
                if (isset($imagenesPorNombre[$nombreNormalizado])) {
                    $imagenUrl = $imagenesPorNombre[$nombreNormalizado]->RUTA;
                }

                return (object)[
                    'id' => $capital->ID_CAPITAL,
                    'nombre' => $nombre,
                    'slug' => $slug,
                    'descripcion' => $capital->DESCRIPCION ?? null,
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
            // Find capital by slug
            $capitales = DB::table('tabla_capitales')->get();
            $capital = null;

            foreach ($capitales as $cap) {
                $capSlug = Str::slug($cap->NOMBRE_CAPITAL);
                if ($capSlug === $slug) {
                    $capital = $cap;
                    break;
                }
            }

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

            $item = (object)[
                'id' => $capital->ID_CAPITAL,
                'nombre' => $nombre,
                'slug' => $slug,
                'descripcion' => $capital->DESCRIPCION ?? null,
                'imagen' => $imagenUrl,
            ];

            return view('pages.detalle-capital', compact('item'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
