<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = 'bitacora';

    protected $fillable = [
        'id',
        'idRegistro', // ID of the record being modified
        'descripcion', // Description of the action, format csv
        'tipoAccion', // 1 for insert, 2 for update, 3 for delete
        'idUsuario', // ID of the user who performed the action
        'created_at', // Timestamp of when the action was performed
        'updated_at', // Timestamp of when the record was last updated
    ];

}
