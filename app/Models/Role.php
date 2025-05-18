<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'rol';

    protected $fillable = [
        'nombre',
        'estado' //1= invisible, 0 = visible
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_rol');
    }
}
