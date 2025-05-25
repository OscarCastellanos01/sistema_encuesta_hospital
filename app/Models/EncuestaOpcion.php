<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EncuestaOpcion extends Model
{
    protected $table = 'encuesta_opciones';

    protected $fillable = [
        'idPregunta',
        'valor',
        'etiqueta'
    ];

    public function pregunta(): BelongsTo
    {
        return $this->belongsTo(EncuestaPregunta::class, 'idPregunta');
    }
}
