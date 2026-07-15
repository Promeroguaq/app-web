<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'tabla_regiones';
    protected $primaryKey = 'ID_REGION';

    protected $fillable = [
        'ID_REGION',
        'NOMBRE_REGION',
        'DESCRIPCION',
        'ID_LOCALITIES',
    ];

    public function locality()
    {
        return $this->belongsTo(Locality::class, 'ID_LOCALITIES', 'ID');
    }
}
