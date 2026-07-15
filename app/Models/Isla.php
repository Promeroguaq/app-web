<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isla extends Model
{
    use HasFactory;

    protected $table = 'tabla_islas';
    protected $primaryKey = 'ID_ISLA';

    protected $fillable = [
        'nombre_isla',
        'descripcion'
    ];
}
