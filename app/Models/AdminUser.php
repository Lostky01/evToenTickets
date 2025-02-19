<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminUser extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $table = 'admin_user';
    protected $guard = 'admin';

    protected $fillable = [
        'email',
        'password'
    ];

    public function Event() {
        return $this->belongsTo(Event::class);
    }
}
