<?php

namespace App\Http\Controllers;

use App\Models\FeriaFiesta;
use App\Services\ImageResolver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FeriaController extends Controller
{
    /**
     * Mostrar todas las fiestas y ferias agrupadas por mes
     */
    public function index()
    {
        // Cargar imágenes en memoria una sola vez (evitar N+1)
        $imagenesMap = \Cache::remember('imagenes_map_global', 1800, function () {
            return \DB::table('tabla_imagenes')
                ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                ->get();
        });

        // Cargar fiestas y ferias con paginación
        $ferias = FeriaFiesta::paginate(12);

        // Array para rastrear imágenes ya usadas
        $usedImages = [];

        // Mapear datos a formato consistente
        $feriasFormateadas = $ferias->map(function ($feria) use (&$usedImages, $imagenesMap) {
            $nombre = $feria->NOMBRE_FERIAS_Y_FIESTAS ?? null;
            $ciudadDepartamento = $feria->CIUDAD_DEPARTAMENTO ?? null;
            $fecha = $feria->FECHA ?? null;
            $descripcion = $feria->DESCRIPCION ?? null;

            // Extraer mes de la fecha
            $mes = $this->extraerMes($fecha);

            // Generar slug
            $slug = $nombre ? Str::slug($nombre) : null;

            // Separar ciudad y departamento si están juntos
            $ciudad = null;
            $departamento = null;
            if ($ciudadDepartamento) {
                $partes = explode(',', $ciudadDepartamento);
                $ciudad = trim($partes[0] ?? '');
                $departamento = isset($partes[1]) ? trim($partes[1]) : null;
            }

            // Resolver imagen usando ImageResolver con imágenes pre-cargadas
            $imagenData = ImageResolver::forFeria($feria, $usedImages, $imagenesMap);

            return [
                'id' => $feria->ID_FIESTA,
                'nombre' => $nombre,
                'slug' => $slug,
                'descripcion' => $descripcion,
                'fecha' => $fecha,
                'mes' => $mes,
                'ciudad' => $ciudad,
                'departamento' => $departamento,
                'ciudad_departamento' => $ciudadDepartamento,
                'imagen' => $imagenData['url'],
                'imagen_id' => $imagenData['id'],
                'match_type' => $imagenData['match_type'],
            ];
        })->filter(function ($feria) {
            // Filtrar registros inválidos (placeholders)
            $nombre = $feria['nombre'] ?? '';
            $descripcion = $feria['descripcion'] ?? '';
            $fecha = $feria['fecha'] ?? '';
            $ubicacion = $feria['ciudad_departamento'] ?? '';

            // Excluir si el nombre es un placeholder
            if ($nombre === 'NOMBRE_FERIAS_Y_FIESTAS' || empty($nombre)) {
                Log::warning('Feria descartada por nombre inválido', ['feria' => $feria]);
                return false;
            }

            // Excluir si la descripción es un placeholder
            if ($descripcion === 'DESCRIPCION') {
                Log::warning('Feria descartada por descripción placeholder', ['feria' => $feria]);
                return false;
            }

            // Excluir si la fecha es un placeholder
            if ($fecha === 'FECHA') {
                Log::warning('Feria descartada por fecha placeholder', ['feria' => $feria]);
                return false;
            }

            // Excluir si la ubicación es un placeholder
            if ($ubicacion === 'CIUDAD_DEPARTAMENTO') {
                Log::warning('Feria descartada por ubicación placeholder', ['feria' => $feria]);
                return false;
            }

            return true;
        })->values();

        // Agrupar por mes
        $feriasPorMes = $feriasFormateadas->groupBy('mes');

        // Ordenar meses en orden calendario
        $ordenMeses = [
            'Enero' => 1,
            'Febrero' => 2,
            'Marzo' => 3,
            'Abril' => 4,
            'Mayo' => 5,
            'Junio' => 6,
            'Julio' => 7,
            'Agosto' => 8,
            'Septiembre' => 9,
            'Octubre' => 10,
            'Noviembre' => 11,
            'Diciembre' => 12,
            'Sin mes registrado' => 99,
        ];

        $feriasPorMesOrdenadas = $feriasPorMes->sortBy(function ($ferias, $mes) use ($ordenMeses) {
            return $ordenMeses[$mes] ?? 99;
        });

        // Calcular estadísticas
        $stats = [
            'total' => $feriasFormateadas->count(),
            'departamentos' => $feriasFormateadas->pluck('departamento')->filter()->unique()->count(),
            'ciudades' => $feriasFormateadas->pluck('ciudad')->filter()->unique()->count(),
            'meses' => $feriasPorMes->count(),
        ];

        // Seleccionar evento destacado para el hero (prioridad: con imagen, con nombre real, con descripción)
        $eventoDestacado = $feriasFormateadas->first(function ($feria) {
            return !empty($feria['imagen']) && !empty($feria['nombre']) && !empty($feria['descripcion']);
        });

        return view('pages.fiestas-ferias', compact('feriasPorMesOrdenadas', 'stats', 'eventoDestacado', 'ferias'));
    }

    /**
     * Mostrar detalle de una feria específica
     */
    public function show($id)
    {
        $feria = FeriaFiesta::findOrFail($id);

        $nombre = $feria->NOMBRE_FERIAS_Y_FIESTAS ?? null;
        $ciudadDepartamento = $feria->CIUDAD_DEPARTAMENTO ?? null;
        $fecha = $feria->FECHA ?? null;
        $descripcion = $feria->DESCRIPCION ?? null;

        $mes = $this->extraerMes($fecha);

        // Separar ciudad y departamento
        $ciudad = null;
        $departamento = null;
        if ($ciudadDepartamento) {
            $partes = explode(',', $ciudadDepartamento);
            $ciudad = trim($partes[0] ?? '');
            $departamento = isset($partes[1]) ? trim($partes[1]) : null;
        }

        $feriaFormateada = [
            'id' => $feria->ID_FIESTA,
            'nombre' => $nombre,
            'slug' => $nombre ? Str::slug($nombre) : null,
            'descripcion' => $descripcion,
            'fecha' => $fecha,
            'mes' => $mes,
            'ciudad' => $ciudad,
            'departamento' => $departamento,
            'ciudad_departamento' => $ciudadDepartamento,
        ];

        // Cargar todas las ferias para eventos relacionados
        $todasFerias = FeriaFiesta::all();

        // Array para rastrear imágenes ya usadas en relacionados
        $usedImagesRelated = [];

        // Mapear a formato consistente
        $feriasFormateadas = $todasFerias->map(function ($f) use (&$usedImagesRelated) {
            $n = $f->NOMBRE_FERIAS_Y_FIESTAS ?? null;
            $cd = $f->CIUDAD_DEPARTAMENTO ?? null;
            $fec = $f->FECHA ?? null;
            $desc = $f->DESCRIPCION ?? null;

            $m = $this->extraerMes($fec);
            $s = $n ? Str::slug($n) : null;

            $c = null;
            $d = null;
            if ($cd) {
                $p = explode(',', $cd);
                $c = trim($p[0] ?? '');
                $d = isset($p[1]) ? trim($p[1]) : null;
            }

            // Resolver imagen usando ImageResolver
            $imagenData = ImageResolver::forFeria($f, $usedImagesRelated);

            return (object)[
                'id' => $f->ID_FIESTA,
                'nombre' => $n,
                'slug' => $s,
                'descripcion' => $desc,
                'fecha' => $fec,
                'mes' => $m,
                'ciudad' => $c,
                'departamento' => $d,
                'ciudad_departamento' => $cd,
                'categoria' => 'Fiesta y Feria',
                'imagen' => $imagenData['url'],
                'imagen_id' => $imagenData['id'],
                'match_type' => $imagenData['match_type'],
            ];
        })->filter(fn ($f) => !empty($f->nombre))->values();

        // Eventos relacionados (excluyendo el actual)
        $relatedEvents = $feriasFormateadas->filter(function ($f) use ($id) {
            return $f->id !== $id;
        })->take(6)->values();

        // Obtener departamentos y meses únicos para filtros
        $departamentos = $feriasFormateadas->pluck('departamento')->filter()->unique()->sort()->values();
        $meses = $feriasFormateadas->pluck('mes')->filter()->unique()->values();

        // Cargar reviews de la feria
        $reviews = $feria->reviews()->approved()->latest()->get();
        $averageRating = $feria->averageRating();
        $reviewsCount = $feria->reviewsCount();

        return view('pages.fiesta-detalle', compact('feriaFormateada', 'relatedEvents', 'departamentos', 'meses', 'reviews', 'averageRating', 'reviewsCount'));
    }

    /**
     * Extraer mes de una fecha en formato texto
     */
    private function extraerMes($fecha)
    {
        if (empty($fecha)) {
            return 'Sin mes registrado';
        }

        $fechaLower = strtolower($fecha);

        // Buscar nombres de meses en español
        $meses = [
            'enero' => 'Enero',
            'febrero' => 'Febrero',
            'marzo' => 'Marzo',
            'abril' => 'Abril',
            'mayo' => 'Mayo',
            'junio' => 'Junio',
            'julio' => 'Julio',
            'agosto' => 'Agosto',
            'septiembre' => 'Septiembre',
            'octubre' => 'Octubre',
            'noviembre' => 'Noviembre',
            'diciembre' => 'Diciembre',
        ];

        foreach ($meses as $clave => $nombre) {
            if (str_contains($fechaLower, $clave)) {
                return $nombre;
            }
        }

        return 'Sin mes registrado';
    }
}
