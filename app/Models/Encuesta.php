<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function tipoCita()
    {
        return $this->belongsTo(TipoCita::class, 'idTipoCita');
    }
}
