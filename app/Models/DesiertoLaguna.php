<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesiertoLaguna extends Model
{
    use HasFactory;

    protected $table = 'tabla_desierto_laguna';

    protected $primaryKey = 'ID_DESIERTO';

    public $timestamps = false;

    protected $fillable = [
        'ID_DESIERTO',
        'NOMBRE_DESIERTO_LAGUNAS',
        'DESCRIPCION',
        'ID_LOCALITIES'
    ];
}
