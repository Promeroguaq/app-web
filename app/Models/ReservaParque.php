<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaParque extends Model
{
    use HasFactory;

    protected $table = 'tabla_reservas';

    protected $primaryKey = 'ID_RESERVAS';

    public $timestamps = false;

    protected $fillable = [
        'NOMBRE_RESERVAS_O_PARQUES',
        'ID_LOCALITIES',
        'DESCRIPCION',
        'ID_REGION'
    ];

    /**
     * Obtener el slug del nombre
     */
    public function getSlugAttribute()
    {
        return \Illuminate\Support\Str::slug($this->NOMBRE_RESERVAS_O_PARQUES);
    }

    /**
     * Obtener el nombre para mostrar
     */
    public function getNombreAttribute()
    {
        return $this->NOMBRE_RESERVAS_O_PARQUES;
    }

    /**
     * Obtener la descripción para mostrar
     */
    public function getDescripcionAttribute()
    {
        return $this->DESCRIPCION;
    }
}
