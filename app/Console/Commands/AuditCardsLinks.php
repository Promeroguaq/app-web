<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class AuditCardsLinks extends Command
{
    protected $signature = 'cards:audit-links';
    protected $description = 'Auditoría de enlaces de cards para identificar 404s';

    public function handle()
    {
        $this->info('=== Auditoría de Links de Cards ===');
        $this->newLine();

        // Configuración de módulos con sus claves primarias reales
        $modules = [
            'playas' => [
                'table' => 'tabla_playas',
                'primary_key' => 'ID_PLAYA',
                'route' => 'puntos-interes.playas.show',
                'controller' => 'PlayaController@show',
            ],
            'museos' => [
                'table' => 'tabla_museos',
                'primary_key' => 'ID_MUSEO',
                'route' => 'puntos-interes.museos.show',
                'controller' => 'MuseoController@show',
            ],
            'iglesias' => [
                'table' => 'tabla_iglesias',
                'primary_key' => 'ID_IGLESIA',
                'route' => 'puntos-interes.iglesias.show',
                'controller' => 'IglesiaController@show',
            ],
            'termales' => [
                'table' => 'tabla_termales',
                'primary_key' => 'ID_TERMALES',
                'route' => 'puntos-interes.termales.show',
                'controller' => 'TermalController@show',
            ],
            'reservas-naturales' => [
                'table' => 'tabla_reservas',
                'primary_key' => 'ID_RESERVAS',
                'route' => 'puntos-interes.reservas-naturales.show',
                'controller' => 'ReservaParqueController@show',
            ],
            'parques-tematicos' => [
                'table' => 'tabla_parque_tematicos',
                'primary_key' => 'ID_PARQUES',
                'route' => 'puntos-interes.parques-tematicos.show',
                'controller' => 'ParqueTematicoController@show',
            ],
            'deportes-aventura' => [
                'table' => 'tabla_deporte_aventura',
                'primary_key' => 'ID_DEPORTES',
                'route' => 'puntos-interes.deportes-aventura.show',
                'controller' => 'DeporteAventuraController@show',
            ],
            'ciclismo' => [
                'table' => 'tabla_ciclismo',
                'primary_key' => 'ID_CICLISMO',
                'route' => 'puntos-interes.ciclismo.show',
                'controller' => 'CiclismoController@show',
            ],
            'desiertos-lagunas' => [
                'table' => 'tabla_desierto_laguna',
                'primary_key' => 'ID_DESIERTO',
                'route' => 'puntos-interes.desiertos-lagunas.show',
                'controller' => 'DesiertoLagunaController@show',
            ],
            'islas' => [
                'table' => 'tabla_islas',
                'primary_key' => 'ID_ISLA',
                'route' => 'puntos-interes.islas.show',
                'controller' => 'IslaController@show',
            ],
        ];

        $results = [];

        foreach ($modules as $module => $config) {
            $this->info("Auditoría módulo: {$module}");
            $this->line("Tabla: {$config['table']}");
            $this->line("Clave primaria: {$config['primary_key']}");
            $this->line("Ruta: {$config['route']}");
            $this->line("Controlador: {$config['controller']}");
            $this->newLine();

            // Obtener muestra de registros
            try {
                $sample = DB::table($config['table'])
                    ->select($config['primary_key'])
                    ->limit(3)
                    ->get();

                if ($sample->isEmpty()) {
                    $this->warn("  No hay registros en {$config['table']}");
                    $this->newLine();
                    continue;
                }

                foreach ($sample as $record) {
                    $id = $record->{$config['primary_key']};
                    $this->line("  Registro ID: {$id}");

                    // Generar URL como lo hace la vista
                    try {
                        $url = route($config['route'], $id);
                        $this->line("  URL generada: {$url}");

                        // Verificar si la ruta existe
                        $routeExists = Route::has($config['route']);
                        $this->line("  Ruta existe: " . ($routeExists ? 'SÍ' : 'NO'));

                        // Verificar si el registro existe en BD
                        $recordExists = DB::table($config['table'])
                            ->where($config['primary_key'], $id)
                            ->exists();
                        $this->line("  Registro existe: " . ($recordExists ? 'SÍ' : 'NO'));

                        $results[] = [
                            'module' => $module,
                            'id' => $id,
                            'url' => $url,
                            'route_exists' => $routeExists,
                            'record_exists' => $recordExists,
                            'primary_key' => $config['primary_key'],
                            'controller' => $config['controller'],
                        ];

                        if (!$routeExists || !$recordExists) {
                            $this->error("  ❌ PROBLEMA DETECTADO");
                        } else {
                            $this->info("  ✅ OK");
                        }

                    } catch (\Exception $e) {
                        $this->error("  ❌ Error generando URL: " . $e->getMessage());
                        $results[] = [
                            'module' => $module,
                            'id' => $id,
                            'url' => 'ERROR',
                            'route_exists' => false,
                            'record_exists' => false,
                            'primary_key' => $config['primary_key'],
                            'controller' => $config['controller'],
                            'error' => $e->getMessage(),
                        ];
                    }

                    $this->newLine();
                }

            } catch (\Exception $e) {
                $this->error("  ❌ Error accediendo a tabla {$config['table']}: " . $e->getMessage());
                $this->newLine();
            }
        }

        // Resumen
        $this->info('=== RESUMEN ===');
        $this->newLine();

        $problems = collect($results)->filter(function ($r) {
            return !$r['route_exists'] || !$r['record_exists'] || isset($r['error']);
        });

        $this->line("Total URLs auditadas: " . count($results));
        $this->line("Problemas encontrados: " . $problems->count());
        $this->newLine();

        if ($problems->count() > 0) {
            $this->error('=== PROBLEMAS DETECTADOS ===');
            $this->newLine();

            foreach ($problems as $problem) {
                $this->error("Módulo: {$problem['module']}");
                $this->error("  ID: {$problem['id']}");
                $this->error("  URL: {$problem['url']}");
                $this->error("  Clave primaria: {$problem['primary_key']}");
                $this->error("  Controlador: {$problem['controller']}");
                if (isset($problem['error'])) {
                    $this->error("  Error: {$problem['error']}");
                } else {
                    if (!$problem['route_exists']) {
                        $this->error("  ❌ La ruta nombrada no existe");
                    }
                    if (!$problem['record_exists']) {
                        $this->error("  ❌ El registro no existe en BD");
                    }
                }
                $this->newLine();
            }
        } else {
            $this->info('✅ No se detectaron problemas en la auditoría');
        }

        return Command::SUCCESS;
    }
}
