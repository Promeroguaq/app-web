<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playa extends Model
{
    use HasFactory;

    protected $table = 'tabla_playas';

    protected $fillable = [
        'nombre',
        'locality_id',
        'descripcion',
        'country_id',
    ];
}
