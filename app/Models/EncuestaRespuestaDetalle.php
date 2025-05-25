<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EncuestaRespuestaDetalle extends Model
{
    protected $fillable = [
        'idEncuestaRespuesta',
        'idPregunta',
        'respuestaTexto',
        'respuestaEntero',
        'respuestaFecha',
        'respuestaHora',
        'respuestaFechaHora',
        'respuestaOpcion',
        'idNivelSatisfaccion',
    ];

    public function encuestaRespuesta(): BelongsTo
    {
        return $this->belongsTo(EncuestaRespuesta::class, 'idEncuestaRespuesta');
    }

    public function pregunta(): BelongsTo
    {
        return $this->belongsTo(EncuestaPregunta::class, 'idPregunta');
    }

    public function nivelSatisfaccion(): BelongsTo
    {
        return $this->belongsTo(nivel_satisfaccion::class, 'idNivelSatisfaccion');
    }
}
