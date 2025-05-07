<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'rol';

    protected $fillable = [
        'nombreRol',
        'descripcion',
        'estado'
    ];
}
