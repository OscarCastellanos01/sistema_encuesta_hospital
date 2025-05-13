<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function encuesta(): BelongsTo
    {
        return $this->belongsTo(Encuesta::class ,'idEncuesta');
    }

    public function facilitador(): BelongsTo
    {
        return $this->belongsTo(user::class ,'idFacilitador');
    }

    public function especialidad(): BelongsTo
    {
        return $this->belongsTo(Especialidad::class ,'idEspecialidad');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(EncuestaRespuestaDetalle::class, 'idEncuestaRespuesta');
    }
}
