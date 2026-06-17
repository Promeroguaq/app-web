<?php

namespace App\Http\Controllers;

use App\Models\FeriaFiesta;
use App\Services\ImageResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EventosController extends Controller
{
    /**
     * Mostrar página de fiestas y ferias
     */
    public function index(Request $request)
    {
        try {
            set_time_limit(120);

            // Cargar datos reales desde tabla_ferias
            $feriasDB = FeriaFiesta::all();

            // Array para rastrear imágenes ya usadas
            $usedImages = [];

            // Mapear datos a formato consistente
            $ferias = $feriasDB->map(function ($feria) use (&$usedImages) {
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

                // Resolver imagen usando ImageResolver
                $imagenData = ImageResolver::forFeria($feria, $usedImages);

                return (object)[
                    'id' => $feria->ID_FIESTA,
                    'nombre' => $nombre,
                    'slug' => $slug,
                    'descripcion' => $descripcion,
                    'fecha' => $fecha,
                    'mes' => $mes,
                    'ciudad' => $ciudad,
                    'departamento' => $departamento,
                    'ciudad_departamento' => $ciudadDepartamento,
                    'categoria' => 'Fiesta y Feria',
                    'imagen' => $imagenData['url'],
                    'imagen_id' => $imagenData['id'],
                    'match_type' => $imagenData['match_type'],
                ];
            })->filter(function ($feria) {
                // Filtrar registros inválidos (placeholders)
                $nombre = $feria->nombre ?? '';
                $descripcion = $feria->descripcion ?? '';
                $fecha = $feria->fecha ?? '';
                $ubicacion = $feria->ciudad_departamento ?? '';

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

            // Obtener departamentos únicos
            $departamentos = $ferias->pluck('departamento')->filter()->unique()->sort()->values();

            // Obtener tipos únicos
            $tipos = collect(['Todos', 'Carnaval', 'Feria', 'Festival', 'Música', 'Cultura']);

            // Aplicar filtros si existen
            if ($request->filled('busqueda')) {
                $busqueda = $request->get('busqueda');
                $ferias = $ferias->filter(function($item) use ($busqueda) {
                    return stripos($item->nombre ?? '', $busqueda) !== false ||
                           stripos($item->descripcion ?? '', $busqueda) !== false ||
                           stripos($item->ciudad ?? '', $busqueda) !== false;
                });
            }

            if ($request->filled('departamento')) {
                $depto = $request->get('departamento');
                $ferias = $ferias->filter(function($item) use ($depto) {
                    return $item->departamento === $depto;
                });
            }

            if ($request->filled('tipo')) {
                $tipo = $request->get('tipo');
                if ($tipo !== 'Todos') {
                    $ferias = $ferias->filter(function($item) use ($tipo) {
                        return str_contains(strtolower($item->nombre ?? ''), strtolower($tipo));
                    });
                }
            }

            return view('pages.eventos', compact('ferias', 'departamentos', 'tipos'));
        } catch (\Exception $e) {
            return view('pages.eventos', [
                'ferias' => collect([]),
                'departamentos' => collect([]),
                'tipos' => collect([]),
                'error' => 'Error al cargar fiestas y ferias: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Mostrar detalle de una fiesta o feria específica
     */
    public function show($slug)
    {
        try {
            set_time_limit(120);

            // Cargar datos reales desde tabla_ferias
            $feriasDB = FeriaFiesta::all();

            // Array para rastrear imágenes ya usadas
            $usedImages = [];

            // Mapear datos a formato consistente
            $ferias = $feriasDB->map(function ($feria) use (&$usedImages) {
                $nombre = $feria->NOMBRE_FERIAS_Y_FIESTAS ?? null;
                $ciudadDepartamento = $feria->CIUDAD_DEPARTAMENTO ?? null;
                $fecha = $feria->FECHA ?? null;
                $descripcion = $feria->DESCRIPCION ?? null;

                $mes = $this->extraerMes($fecha);
                $slug = $nombre ? Str::slug($nombre) : null;

                $ciudad = null;
                $departamento = null;
                if ($ciudadDepartamento) {
                    $partes = explode(',', $ciudadDepartamento);
                    $ciudad = trim($partes[0] ?? '');
                    $departamento = isset($partes[1]) ? trim($partes[1]) : null;
                }

                // Resolver imagen usando ImageResolver
                $imagenData = ImageResolver::forFeria($feria, $usedImages);

                return (object)[
                    'id' => $feria->ID_FIESTA,
                    'nombre' => $nombre,
                    'slug' => $slug,
                    'descripcion' => $descripcion,
                    'fecha' => $fecha,
                    'mes' => $mes,
                    'ciudad' => $ciudad,
                    'departamento' => $departamento,
                    'ciudad_departamento' => $ciudadDepartamento,
                    'categoria' => 'Fiesta y Feria',
                    'imagen' => $imagenData['url'],
                    'imagen_id' => $imagenData['id'],
                    'match_type' => $imagenData['match_type'],
                ];
            })->filter(function ($feria) {
                // Filtrar registros inválidos (placeholders)
                $nombre = $feria->nombre ?? '';
                $descripcion = $feria->descripcion ?? '';
                $fecha = $feria->fecha ?? '';
                $ubicacion = $feria->ciudad_departamento ?? '';

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

            $feria = $ferias->firstWhere('slug', $slug);

            if (!$feria) {
                abort(404);
            }

            // Cargar eventos relacionados (excluyendo el actual)
            $relatedEvents = $ferias->filter(function ($f) use ($feria) {
                return $f->id !== $feria->id;
            })->take(6)->values();

            // Obtener departamentos únicos para filtros
            $departamentos = $ferias->pluck('departamento')->filter()->unique()->sort()->values();

            // Obtener meses únicos para filtros
            $meses = $ferias->pluck('mes')->filter()->unique()->values();

            return view('pages.evento-detalle', compact('feria', 'relatedEvents', 'departamentos', 'meses'));
        } catch (\Exception $e) {
            abort(404);
        }
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

    /**
     * Mostrar formulario para crear nuevo evento
     */
    public function create()
    {
        try {
            $departamentos = \DB::table('tabla_departamentos')
                ->distinct()
                ->orderBy('NOMBRE_DEPARTAMENTO')
                ->pluck('NOMBRE_DEPARTAMENTO');
            
            return view('pages.eventos-create', compact('departamentos'));
        } catch (\Exception $e) {
            return view('pages.eventos-create', [
                'departamentos' => collect([]),
                'error' => 'No se puede cargar el formulario de creación.'
            ]);
        }
    }

    /**
     * Guardar nueva fiesta o feria
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|max:255',
            'tipo' => 'required|max:100',
            'departamento' => 'required|max:100',
            'municipio' => 'required|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'descripcion' => 'required',
            'precio' => 'nullable|numeric|min:0',
            'imagen' => 'nullable|url'
        ]);

        try {
            \DB::table('tabla_ferias')->insert([
                'NOMBRE_FERIA' => $validated['nombre'],
                'TIPO' => $validated['tipo'],
                'DEPARTAMENTO' => $validated['departamento'],
                'MUNICIPIO' => $validated['municipio'],
                'FECHA_INICIO' => $validated['fecha_inicio'],
                'FECHA_FIN' => $validated['fecha_fin'],
                'DESCRIPCION' => $validated['descripcion'],
                'PRECIO' => $validated['precio'] ?? 0,
                'IMAGEN' => $validated['imagen'] ?? null,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('eventos')
                ->with('success', 'Fiesta o feria creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear la fiesta o feria: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Eliminar una fiesta o feria
     */
    public function destroy($id)
    {
        try {
            $deleted = \DB::table('tabla_ferias')->where('ID_FERIA', $id)->delete();
            
            if ($deleted) {
                return redirect()->route('eventos')
                    ->with('success', 'Fiesta o feria eliminada exitosamente.');
            } else {
                return redirect()->route('eventos')
                    ->with('error', 'Fiesta o feria no encontrada.');
            }
        } catch (\Exception $e) {
            return redirect()->route('eventos')
                ->with('error', 'Error al eliminar la fiesta o feria: ' . $e->getMessage());
        }
    }
}
