<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EncuestaPregunta extends Model
{
    protected $fillable = [
        'idEncuesta',
        'tituloPregunta',
        'tipoPregunta',
        'estadoPregunta',
    ];

    public function encuesta(): BelongsTo
    {
        return $this->belongsTo(Encuesta::class ,'idEncuesta');
    }

    public function opciones(): HasMany
    {
        return $this->hasMany(EncuestaOpcion::class, 'idPregunta');
    }
}
