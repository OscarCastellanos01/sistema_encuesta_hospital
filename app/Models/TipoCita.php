<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCita extends Model
{
    protected $table = 'tipo_cita';

    protected $fillable = [
       'nombreTipoCita',
       'estadoTipoCita'
    ];
}
