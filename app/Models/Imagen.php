<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Imagen extends Model
{
    use HasFactory;

    protected $table = 'tabla_imagenes';

    protected $fillable = [
        'ID_IMAGEN',
        'NOMBRE_IMAGEN',
        'RUTA',
    ];

    protected $primaryKey = 'ID_IMAGEN';
    public $timestamps = false;
}
