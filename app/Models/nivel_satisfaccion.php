<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nivel_satisfaccion extends Model
{
    protected $table = 'nivel_satisfaccion';

    protected $fillable = [
        'codigoNivelSatisfaccion',
        'nombreNivelSatisfaccion',
        'emojiSatisfaccion',
        'estadoNivelSatisfaccion'
    ];
}
