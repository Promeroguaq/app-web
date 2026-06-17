<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParqueTematico extends Model
{
    use HasFactory;

    protected $table = 'tabla_parque_tematicos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'locality_id',
        'country_id'
    ];
}
