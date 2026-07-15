<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locality extends Model
{
    protected $table = 'tabla_localities';
    protected $primaryKey = 'ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ID',
        'REGION',
        'MUNICIPIOS',
        'DEPARTAMENTO',
    ];

    // Accessors for consistent naming
    public function getIdAttribute($value)
    {
        return $this->attributes['ID'];
    }

    public function getRegionAttribute($value)
    {
        return $this->attributes['REGION'];
    }

    public function getMunicipioAttribute($value)
    {
        return $this->attributes['MUNICIPIOS'];
    }

    public function getDepartamentoAttribute($value)
    {
        return $this->attributes['DEPARTAMENTO'];
    }
}
