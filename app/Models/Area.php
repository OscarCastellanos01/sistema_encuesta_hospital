<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';

    protected $fillable = [
        'nombreArea',
    ];

    public function encuestas()
    {
        return $this->hasMany(Encuesta::class, 'area_id');
    }
}
