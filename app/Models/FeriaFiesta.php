<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class FeriaFiesta extends Model
{
    use HasFactory;

    protected $table = 'tabla_ferias';

    protected $primaryKey = 'ID_FIESTA';

    public $timestamps = false;

    protected $fillable = [
        'ID_FIESTA',
        'NOMBRE_FERIAS_Y_FIESTAS',
        'CIUDAD_DEPARTAMENTO',
        'FECHA',
        'DESCRIPCION'
    ];

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
