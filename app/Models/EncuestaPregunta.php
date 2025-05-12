<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncuestaPregunta extends Model
{
    protected $fillable = [
        'idEncuesta',
        'tituloPregunta',
        'estadoPregunta',
    ];
}
