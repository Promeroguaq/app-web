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
        'imageable_id',
        'imageable_type',
        'categoria',
        'principal',
        'orden',
    ];

    protected $casts = [
        'principal' => 'boolean',
        'orden' => 'integer',
    ];

    /**
     * Relación polimórfica con cualquier entidad
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope para obtener imágenes principales
     */
    public function scopePrincipal($query)
    {
        return $query->where('principal', true);
    }

    /**
     * Scope para filtrar por categoría
     */
    public function scopeByCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    /**
     * Scope para ordenar por orden
     */
    public function scopeOrdenados($query)
    {
        return $query->orderBy('orden');
    }
}
