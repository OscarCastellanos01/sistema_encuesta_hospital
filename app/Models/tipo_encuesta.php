<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipo_encuesta extends Model
{
    protected $table = 'tipo_encuesta';

    protected $fillable = [
        'nombreTipoEncuesta',
        'estado'
    ];
}
