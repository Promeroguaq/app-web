<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iglesia extends Model
{
    use HasFactory;

    protected $table = 'tabla_iglesias';
    protected $primaryKey = 'ID_IGLESIA';

    protected $fillable = [
        'ID_IGLESIA',
        'NOMBRE_IGLESIA',
        'DESCRIPCION',
        'ID_LOCALITIES',
        'DEPARTAMENTO',
    ];

    public function locality()
    {
        return $this->belongsTo(Locality::class, 'ID_LOCALITIES', 'ID');
    }
}
