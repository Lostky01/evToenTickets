<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nis', 'email', 'name', 'password', 'user_type', 'is_verified',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

}
