<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class DeporteAventura extends Model
{
    use HasFactory;

    protected $table = 'tabla_deporte_aventura';

    protected $fillable = [
        'nombre',
        'locality_id',
        'descripcion',
    ];

    // Relación
    public function locality()
    {
        return $this->belongsTo(Locality::class);
    }

    /**
     * Relación polimórfica con imágenes
     */
    public function imagenes(): MorphMany
    {
        return $this->morphMany(Imagen::class, 'imageable', 'imageable_type', 'imageable_id');
    }
}