<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaGastronomica extends Model
{
    use HasFactory;

    protected $table = 'tabla_gastronomia';
    protected $primaryKey = 'ID_PLATOS';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'PLATOS_TIPICOS',
        'CATEGORIA',
        'DEPARTAMENTO',
        'REGIÓN',
        'DESCRIPCION'
    ];

    // Explicitly set no default orderBy to prevent any automatic ordering
    protected $orderBy = null;

    protected static function boot()
    {
        parent::boot();
        // Remove any global scopes that might be adding orderBy
    }

    // Relación con Localities si existe
    // public function locality() {
    //     return $this->belongsTo(Locality::class, 'id_localities');
    // }
}
