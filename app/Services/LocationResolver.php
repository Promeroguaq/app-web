<?php

namespace App\Services;

use App\Models\Locality;
use Illuminate\Database\Eloquent\Model;

class LocationResolver
{
    /**
     * Get municipio and departamento formatted as "Municipio, Departamento"
     */
    public function municipioDepartamento($item): string
    {
        $locality = $this->getLocality($item);

        if (!$locality) {
            return 'Ubicación por confirmar';
        }

        if (empty($locality->municipio) && empty($locality->departamento)) {
            return 'Ubicación por confirmar';
        }

        if (empty($locality->municipio)) {
            return $locality->departamento;
        }

        if (empty($locality->departamento)) {
            return $locality->municipio;
        }

        return "{$locality->municipio}, {$locality->departamento}";
    }

    /**
     * Get region name
     */
    public function region($item): string
    {
        $locality = $this->getLocality($item);

        if (!$locality || empty($locality->region)) {
            return '';
        }

        return $locality->region;
    }

    /**
     * Get full location with region
     * Format: "Municipio, Departamento\nRegión: Region Name"
     */
    public function fullLocation($item): string
    {
        $municipioDepartamento = $this->municipioDepartamento($item);
        $region = $this->region($item);

        if ($municipioDepartamento === 'Ubicación por confirmar') {
            return $municipioDepartamento;
        }

        if (empty($region)) {
            return $municipioDepartamento;
        }

        return "{$municipioDepartamento}\nRegión: {$region}";
    }

    /**
     * Check if item has a valid location
     */
    public function hasValidLocation($item): bool
    {
        $locality = $this->getLocality($item);

        if (!$locality) {
            return false;
        }

        return !empty($locality->municipio) || !empty($locality->departamento);
    }

    /**
     * Get locality from item
     * Handles both Eloquent models with locality() relation and raw DB results
     */
    protected function getLocality($item)
    {
        // If item is already a Locality model
        if ($item instanceof Locality) {
            return $item;
        }

        // If item has locality relation loaded
        if ($item instanceof Model && $item->relationLoaded('locality')) {
            return $item->locality;
        }

        // If item has locality_id or similar field, try to load it
        if ($item instanceof Model) {
            $localityId = $this->extractLocalityId($item);
            if ($localityId) {
                return Locality::find($localityId);
            }
        }

        // If item is a stdClass from DB query with locality data
        if (is_object($item) && isset($item->locality_municipio)) {
            return (object)[
                'municipio' => $item->locality_municipio ?? null,
                'departamento' => $item->locality_departamento ?? null,
                'region' => $item->locality_region ?? null,
            ];
        }

        return null;
    }

    /**
     * Extract locality ID from model
     */
    protected function extractLocalityId(Model $item): ?string
    {
        // Try common field names
        $fields = ['ID_LOCALITIES', 'ID_LOCALITITES', 'locality_id', 'id_localities', 'locality'];

        foreach ($fields as $field) {
            if (isset($item->$field) && !empty($item->$field)) {
                return $item->$field;
            }
        }

        return null;
    }

    /**
     * Get location data directly from tabla_localities by ID
     * Returns object with municipio, departamento, and region
     */
    public static function getByLocalityId(?string $localityId): ?object
    {
        if (!$localityId) {
            return null;
        }

        $locality = \DB::table('tabla_localities')
            ->where('ID', $localityId)
            ->first();

        if (!$locality) {
            return null;
        }

        return (object)[
            'municipio' => $locality->MUNICIPIOS,
            'departamento' => $locality->DEPARTAMENTO,
            'region' => $locality->REGION,
        ];
    }

    /**
     * Get location data by municipality name (fallback for entities without locality_id)
     */
    public static function getByMunicipioName(?string $municipioNombre): ?object
    {
        if (!$municipioNombre) {
            return null;
        }

        $locality = \DB::table('tabla_localities')
            ->where('MUNICIPIOS', $municipioNombre)
            ->first();

        if (!$locality) {
            return null;
        }

        return (object)[
            'municipio' => $locality->MUNICIPIOS,
            'departamento' => $locality->DEPARTAMENTO,
            'region' => $locality->REGION,
        ];
    }
}
