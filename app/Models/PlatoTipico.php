<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatoTipico extends Model
{
    use HasFactory;

    protected $table = 'tabla_gastronomia';
    protected $primaryKey = 'ID_PLATOS';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'ID_PLATOS',
        'PLATOS_TIPICOS',
        'CATEGORIA',
        'DEPARTAMENTO',
        'REGIÓN',
        'DESCRIPCION'
    ];

    /**
     * Get the department that owns the dish
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'DEPARTAMENTO', 'NOMBRE_DEPARTAMENTO');
    }
}
