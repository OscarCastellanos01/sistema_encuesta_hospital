<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class tipo_encuesta extends Model
{
    protected $table = 'tipo_encuesta';

    protected $fillable = [
        'nombreTipoEncuesta',
        'estado'
    ];

    // Agrega esta relación
    public function encuestas(): HasMany
    {
        return $this->hasMany(Encuesta::class, 'idTipoEncuesta');
    }
}