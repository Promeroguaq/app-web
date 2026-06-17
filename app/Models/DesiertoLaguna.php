<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesiertoLaguna extends Model
{
    use HasFactory;

    protected $table = 'tabla_desierto_laguna';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_desierto',
        'nombre_desierto_lagunas',
        'id_localities',
        'descripcion'
    ];
}
