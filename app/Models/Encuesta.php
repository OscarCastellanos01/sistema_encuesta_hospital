<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $table = 'encuesta';
    protected $fillable = [
        'idFacilitador', // ID of the facilitator
        'idArea', // ID of the area
        'edadPaciente', // Age of the patient
        'sexoPaciente',
        'idEspecialidad', // ID of the specialty
        'idTipoCita', // ID of the appointment type
        'finalizada', // Indicates if the survey is completed
        'tipo_encuesta_id', // ID of the survey type
    ];

    public function tipoEncuesta()
    {
        return $this->belongsTo(tipo_encuesta::class, 'tipo_encuesta_id');
    }
}
