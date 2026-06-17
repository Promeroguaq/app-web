<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LocalExperienceResolver
{
    /**
     * Get contextual local experiences for a municipality
     */
    public static function forMunicipality($municipioNombre, $departamentoNombre, $departamentoId = null)
    {
        $experiences = [];
        $departmentSlug = Str::slug($departamentoNombre);
        $municipalitySlug = Str::slug($municipioNombre);

        Log::info('Resolving local experiences', [
            'municipio' => $municipioNombre,
            'departamento' => $departamentoNombre,
            'departamento_id' => $departamentoId,
        ]);

        // 1. Try to get activities from actividades table by destination
        if ($departamentoId) {
            try {
                $activities = DB::table('actividades')
                    ->where('destino_id', $departamentoId)
                    ->where('disponible', 1)
                    ->limit(4)
                    ->get();

                foreach ($activities as $activity) {
                    // Validate activity has proper data
                    if (!empty($activity->nombre) && (!empty($activity->descripcion) || !empty($activity->tipo))) {
                        $experiences[] = [
                            'title' => $activity->nombre,
                            'description' => $activity->descripcion ?? 'Actividad local disponible',
                            'category' => $activity->tipo ?? 'Actividad',
                            'image_url' => null,
                            'url' => "#actividad-{$activity->id}",
                            'source' => 'municipality',
                        ];
                    } else {
                        Log::warning('Activity discarded - missing required data', [
                            'activity_id' => $activity->id ?? null,
                            'nombre' => $activity->nombre ?? null,
                        ]);
                    }
                }

                if (count($experiences) >= 4) {
                    Log::info('Experiences from actividades table', ['count' => count($experiences)]);
                    return array_slice($experiences, 0, 4);
                }
            } catch (\Exception $e) {
                Log::warning('Error loading actividades', ['error' => $e->getMessage()]);
            }
        }

        // 2. Only use contextual experiences based on region/department
        // Removed gastronomy as it was showing loose words without proper context
        $contextualExperiences = self::getContextualExperiences($departamentoNombre);
        foreach ($contextualExperiences as $exp) {
            if (count($experiences) < 4) {
                $experiences[] = [
                    'title' => $exp['title'],
                    'description' => $exp['description'],
                    'category' => $exp['category'],
                    'image_url' => null,
                    'url' => route('municipios.categoria.slug', [
                        'departmentSlug' => $departmentSlug,
                        'municipalitySlug' => $municipalitySlug,
                        'categorySlug' => $exp['categorySlug']
                    ]),
                    'source' => 'contextual',
                ];
            }
        }

        Log::info('Final experiences resolved', [
            'count' => count($experiences),
            'experiences' => $experiences,
        ]);

        // Return empty array if no valid experiences
        if (count($experiences) === 0) {
            Log::info('No valid experiences found for municipality', [
                'municipio' => $municipioNombre,
                'departamento' => $departamentoNombre,
            ]);
        }

        return array_slice($experiences, 0, 4);
    }

    /**
     * Get contextual experiences based on department/region
     */
    private static function getContextualExperiences($departamentoNombre)
    {
        $normalizedDept = Str::slug($departamentoNombre);
        $experiences = [];

        // Coffee region experiences
        $coffeeDepartments = ['antioquia', 'caldas', 'risaralda', 'quindio', 'tolima', 'norte-de-santander'];
        if (in_array($normalizedDept, $coffeeDepartments)) {
            $experiences[] = [
                'title' => '☕ Tradición Cafetera',
                'description' => 'Descubre la cultura del café en fincas tradicionales',
                'category' => 'Cultura',
                'categorySlug' => 'cultura',
            ];
        }

        // Pacific region experiences
        $pacificDepartments = ['choco', 'valle-del-cauca', 'cauca', 'narino'];
        if (in_array($normalizedDept, $pacificDepartments)) {
            $experiences[] = [
                'title' => '🐋 Avistamiento de Ballenas',
                'description' => 'Observa ballenas jorobadas en su hábitat natural',
                'category' => 'Naturaleza',
                'categorySlug' => 'naturaleza',
            ];
            $experiences[] = [
                'title' => '🌊 Cultura Pacífica',
                'description' => 'Vive la tradición afrodescendiente y ancestral',
                'category' => 'Cultura',
                'categorySlug' => 'cultura',
            ];
        }

        // Caribbean region experiences
        $caribbeanDepartments = ['atlantico', 'bolivar', 'magdalena', 'cesar', 'la-guajira', 'sucre', 'cordoba'];
        if (in_array($normalizedDept, $caribbeanDepartments)) {
            $experiences[] = [
                'title' => '🏖️ Playas del Caribe',
                'description' => 'Disfruta de playas paradisíacas y aguas cristalinas',
                'category' => 'Naturaleza',
                'categorySlug' => 'naturaleza',
            ];
            $experiences[] = [
                'title' => '🎭 Cultura Caribeña',
                'description' => 'Sumérgete en la música, danza y tradiciones costeñas',
                'category' => 'Cultura',
                'categorySlug' => 'cultura',
            ];
        }

        // Amazon region experiences
        $amazonDepartments = ['amazonas', 'caqueta', 'putumayo', 'guainia', 'guaviare', 'vaupes'];
        if (in_array($normalizedDept, $amazonDepartments)) {
            $experiences[] = [
                'title' => '🌳 Selva Amazónica',
                'description' => 'Explora la biodiversidad más rica del planeta',
                'category' => 'Naturaleza',
                'categorySlug' => 'naturaleza',
            ];
            $experiences[] = [
                'title' => '🦜 Ecoturismo',
                'description' => 'Conoce ecosistemas únicos y especies endémicas',
                'category' => 'Naturaleza',
                'categorySlug' => 'naturaleza',
            ];
        }

        // Orinoquia region experiences
        $orinoquiaDepartments = ['meta', 'casanare', 'arauca', 'vichada'];
        if (in_array($normalizedDept, $orinoquiaDepartments)) {
            $experiences[] = [
                'title' => '🐄 Llanos Orientales',
                'description' => 'Vive la tradición llanera y sus vastos paisajes',
                'category' => 'Naturaleza',
                'categorySlug' => 'naturaleza',
            ];
        }

        // NO generic fallbacks - only show experiences with clear regional context
        // If no specific experiences for this department, return empty array
        return $experiences;
    }
}
