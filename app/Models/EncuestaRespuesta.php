<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncuestaRespuesta extends Model
{
    protected $fillable = [
        'codigoEncuestaRespuesta',
        'idEncuesta',
        'idFacilitador',
        'idEspecialidad',
        'edadPaciente',
        'sexoPaciente',
    ];
}
