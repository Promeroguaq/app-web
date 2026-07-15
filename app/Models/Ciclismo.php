<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ciclismo extends Model
{
    use HasFactory;

    protected $table = 'tabla_ciclismo';

    protected $fillable = [
        'nombre_ruta_ciclismo',
        'id_localities',
        'descripcion',
        'slug',
    ];

    protected $primaryKey = 'ID_CICLISMO';

    public $incrementing = true;

    protected $keyType = 'int';

    public function setNombreRutaCiclismoAttribute($value)
    {
        $this->attributes['nombre_ruta_ciclismo'] = $value;
        if (empty($this->slug)) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    public function locality()
    {
        return $this->belongsTo(Locality::class, 'ID_LOCALITIES', 'ID');
    }
}