<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pregunta extends Model
{
    protected $table = 'pregunta';

    protected $fillable = [
        'textoPregunta',
        'idencuesta',
        'estado'
    ];

    public function encuesta(): BelongsTo
    {
        return $this->belongsTo(Encuesta::class, 'idencuesta');
    }
}
