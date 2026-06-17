<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Departamento extends Model
{
    protected $table = 'tabla_departamentos';
    protected $primaryKey = 'ID_DEPARTAMENTO';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'ID_DEPARTAMENTO',
        'NOMBRE_DEPARTAMENTO',
        'DESCRIPCION'
    ];

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'ID_DEPARTAMENTO', 'ID_DEPARTAMENTO');
    }

    /**
     * Relación polimórfica con imágenes
     */
    public function imagenes(): MorphMany
    {
        return $this->morphMany(Imagen::class, 'imageable', 'imageable_type', 'imageable_id');
    }
}