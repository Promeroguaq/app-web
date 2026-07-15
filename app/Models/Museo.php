<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Museo extends Model
{
    use HasFactory;

    protected $table = 'tabla_museos';
    protected $primaryKey = 'ID_MUSEO';

    protected $fillable = [
        'ID_MUSEO',
        'NOMBRE_MUSEO',
        'DESCRIPCION',
        'ID_LOCALITIES',
        'DEPARTAMENTO',
    ];

    public function locality()
    {
        return $this->belongsTo(Locality::class, 'ID_LOCALITIES', 'ID');
    }
}
