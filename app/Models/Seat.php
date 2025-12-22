<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BookingSeat;

class Seat extends Model
{
    protected $fillable = ['bus_id', 'seat_number', 'is_active'];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    // 🔥 CORE LOGIC: cek kursi tersedia
    public function isAvailableForSchedule($scheduleId)
    {
        return !BookingSeat::where('seat_id', $this->id)
            ->whereHas('booking', function ($q) use ($scheduleId) {
                $q->where('schedule_id', $scheduleId)
                  ->whereIn('status', ['pending', 'confirmed']);
            })
            ->exists();
    }
}
