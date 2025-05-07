<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistroFacilitador extends Model
{
    protected $table = 'registro_facilitador';

    protected $fillable = [
        'idUsuario',
        'idEncuesta'
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function encuesta(): BelongsTo
    {
        return $this->belongsTo(Encuesta::class, 'idEncuesta');
    }
}
