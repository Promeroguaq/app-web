<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadParque extends Model
{
    use HasFactory;

    protected $table = 'tabla_actividad_parque';

    protected $primaryKey = 'ID_ACTIVIDAD';

    protected $fillable = [
        'ID_ACTIVIDAD',
        'NOMBRE_ACTIVIDAD_EN_PARQUE',
        'ID_LOCALITITES',
        'DESCRIPCION'
    ];

    public $timestamps = false;
}
