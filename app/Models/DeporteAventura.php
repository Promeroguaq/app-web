<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class DeporteAventura extends Model
{
    use HasFactory;

    protected $table = 'tabla_deporte_aventura';
    protected $primaryKey = 'ID_DEPORTES';

    protected $fillable = [
        'ID_DEPORTES',
        'NOMBRE_DEPORTE_AVENTURA',
        'MUNICIPIOS',
        'DESCRIPCION'
    ];

    // Nota: Esta tabla NO tiene ID_LOCALITIES, tiene MUNICIPIOS como texto
    // No hay relación directa con tabla_localities

    /**
     * Relación polimórfica con imágenes
     */
    public function imagenes(): MorphMany
    {
        return $this->morphMany(Imagen::class, 'imageable', 'imageable_type', 'imageable_id');
    }
}