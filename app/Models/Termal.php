<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termal extends Model
{
    use HasFactory;

    protected $table = 'tabla_termales';
    protected $primaryKey = 'ID_TERMALES';

    protected $fillable = [
        'ID_TERMALES',
        'NOMBRE_TERMAL',
        'DESCRIPCION',
        'ID_LOCALITIES',
        'DEPARTAMENTO',
    ];

    public function locality()
    {
        return $this->belongsTo(Locality::class, 'ID_LOCALITIES', 'ID');
    }
}
