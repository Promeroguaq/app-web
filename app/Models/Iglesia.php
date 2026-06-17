<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iglesia extends Model
{
    use HasFactory;

    protected $table = 'tabla_iglesias';

    protected $primaryKey = 'id_iglesia';

    protected $fillable = [
        'nombre_iglesia',
        'id_localities',
        'descripcion'
    ];

    public function localidad()
    {
        return $this->belongsTo(Locality::class, 'id_localities');
    }
}
