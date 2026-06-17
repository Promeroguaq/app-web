<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
    use HasFactory;

    protected $table = 'tabla_capitales';

    public $timestamps = false;

    protected $primaryKey = 'ID_CAPITAL';

    protected $fillable = [
        'NOMBRE_CAPITAL',
        'DESCRIPCION',
    ];
}
