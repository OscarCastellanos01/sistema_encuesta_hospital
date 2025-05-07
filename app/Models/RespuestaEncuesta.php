<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RespuestaEncuesta extends Model
{
    protected $table = 'respuesta_encuesta';

    protected $fillable = [
        'idEncuesta',
        'idPregunta',
        'idNivelSatisfaccion'
    ];
    
    public function encuesta(): BelongsTo
    {
        return $this->belongsTo(Encuesta::class,'idEncuesta');
    }

    public function pregunta(): BelongsTo
    {
        return $this->belongsTo(Pregunta::class,'idPregunta');
    }
}
