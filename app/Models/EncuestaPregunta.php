<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EncuestaPregunta extends Model
{
    protected $fillable = [
        'idEncuesta',
        'tituloPregunta',
        'estadoPregunta',
    ];

    public function encuesta(): BelongsTo
    {
        return $this->belongsTo(Encuesta::class ,'idEncuesta');
    }
}
