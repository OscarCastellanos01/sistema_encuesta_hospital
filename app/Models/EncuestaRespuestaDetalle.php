<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncuestaRespuestaDetalle extends Model
{
    protected $fillable = [
        'idEncuestaRespuesta',
        'idPregunta',
        'idNivelSatisfaccion',
    ];
}
