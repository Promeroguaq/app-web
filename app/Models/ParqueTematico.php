<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParqueTematico extends Model
{
    use HasFactory;

    protected $table = 'tabla_parque_tematicos';
    protected $primaryKey = 'ID_PARQUES';

    protected $fillable = [
        'ID_PARQUES',
        'NOMBRE_PARQUES_TEMÁTICOS',
        'DESCRIPCION',
        'ID_LOCALITIES',
    ];

    public function locality()
    {
        return $this->belongsTo(Locality::class, 'ID_LOCALITIES', 'ID');
    }
}
