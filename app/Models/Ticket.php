<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'event_id',
        'ticket_code',
        'is_verified',
        'user_type',
        'is_read'
    ];

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(Users::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function admin()
    {
        return $this->belongsTo(AdminUser::class);
    }

    public function getQrCodeAttribute()
    {
        return route('ticket.qr', ['ticket_code' => $this->ticket_code]);
    }

}
