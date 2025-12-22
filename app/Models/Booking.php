<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'schedule_id',
        'seat_id',
        'status',
        'total_price'
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function seat()
    {
        return $this->hasMany(BookingSeat::class);
    }
}
