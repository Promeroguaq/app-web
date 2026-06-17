<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termal extends Model
{
    use HasFactory;

    protected $table = 'tabla_termales';

    protected $fillable = [
        'nombre',
        'locality_id',
        'descripcion',
        'country_id'
    ];
}
