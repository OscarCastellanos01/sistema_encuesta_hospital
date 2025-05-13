<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Encuesta extends Model
{
    protected $fillable = [
        'codigoEncuesta',
        'tituloEncuesta',
        'descripcionEncuesta',
        'estadoEncuesta',
        'idArea',
        'idTipoEncuesta',
        'idTipoCita',
        'idUser',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class ,'idArea');
    }

    public function tipoEncuesta(): BelongsTo
    {
        return $this->belongsTo(tipo_encuesta::class, 'idTipoEncuesta');
    }

    public function tipoCita(): BelongsTo
    {
        return $this->belongsTo(TipoCita::class, 'idTipoCita');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function respuestas(): HasMany
    {
        return $this->hasMany(EncuestaRespuesta::class, 'idEncuesta');
    }

    public function preguntas(): HasMany
    {
        return $this->hasMany(EncuestaPregunta::class,'idEncuesta');
    }
}
