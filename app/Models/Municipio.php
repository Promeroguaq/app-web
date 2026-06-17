<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'tabla_municipios';
    protected $primaryKey = 'ID_MUNICIPIOS';

    protected $fillable = [
        'ID_MUNICIPIOS',
        'ID_DEPARTAMENTO',
        'NOMBRE_MUNICIPIOS',
        'ID_LOCALITIES',
        'DESCRIPCION'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'ID_DEPARTAMENTO', 'ID_DEPARTAMENTO');
    }

    /**
     * Relación polimórfica con imágenes
     */
    public function imagenes(): MorphMany
    {
        return $this->morphMany(Imagen::class, 'imageable', 'imageable_type', 'imageable_id');
    }

    /**
     * Relación polimórfica con reviews
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable', 'reviewable_type', 'reviewable_id');
    }

    /**
     * Obtener el promedio de calificaciones
     */
    public function averageRating(): float
    {
        return $this->reviews()->approved()->avg('rating') ?? 0;
    }

    /**
     * Obtener el número de reviews aprobadas
     */
    public function reviewsCount(): int
    {
        return $this->reviews()->approved()->count();
    }
}
