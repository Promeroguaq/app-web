<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Museo extends Model
{
    use HasFactory;

    protected $table = 'tabla_museos';
    protected $primaryKey = 'id_museo';

    protected $fillable = [
        'nombre_museo',
        'id_localities',
        'descripcion',
        'id_country'
    ];
}
