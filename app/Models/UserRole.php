<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_role';

    protected $fillable = [
        'user_id',
        'rol_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rol()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }
}
