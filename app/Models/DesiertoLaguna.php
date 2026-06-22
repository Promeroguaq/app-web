<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesiertoLaguna extends Model
{
    use HasFactory;

    protected $table = 'tabla_desierto_laguna';

    protected $primaryKey = 'id';

    protected $fillable = [
        'COL 1',
        'COL 2',
        'COL 3',
        'COL 4',
        'COL 5'
    ];
}
