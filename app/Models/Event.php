<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $fillable = [
        'event_name',
        'event_type',
        'event_date',
        'event_price',
        'event_description',
        'quota_for_public',
        'poster',
    ];

    public function Image() {
        return $this->belongsTo(Event::class);
    }

    public function AdminCreator() {
        return $this->belongsTo(AdminUser::class);
    }
}
