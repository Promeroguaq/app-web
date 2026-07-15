<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playa extends Model
{
    use HasFactory;

    protected $table = 'tabla_playas';
    protected $primaryKey = 'ID_PLAYA';

    protected $fillable = [
        'ID_PLAYA',
        'NOMBRE_PLAYA',
        'DESCRIPCION',
        'ID_LOCALITIES',
        'DEPARTAMENTO',
    ];

    public function locality()
    {
        return $this->belongsTo(Locality::class, 'ID_LOCALITIES', 'ID');
    }
}
