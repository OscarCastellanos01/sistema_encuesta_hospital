<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';

    protected $fillable = [
        'nombreArea',
        'estado',
    ];

    public function encuestas()
    {
        return $this->hasMany(Encuesta::class, 'area_id');
    }

     protected $casts = [
        'estado' => 'boolean',
    ];
}
