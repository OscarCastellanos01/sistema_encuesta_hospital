<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table = 'especialidad';
    protected $fillable = [
        'nombreEspecialidad',
        'estadoEspecialidad'
    ];

}
