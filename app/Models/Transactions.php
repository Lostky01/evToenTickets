<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'event_id',
        'transaction_number',
        'bukti_tf',
        'is_confirmed',

    ];


    public function admin() {
        return $this->belongsTo(AdminUser::class);
    }

    public function user() {
        return $this->belongsTo(Users::class);
    }
    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }
    public function event() {
        return $this->belongsTo(Event::class);
    }
}
