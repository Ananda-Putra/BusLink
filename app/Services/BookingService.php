<?php

namespace App\Services;

use App\Models\Seat;
use App\Models\Booking;
use App\Models\BookingSeat;
use Illuminate\Support\Facades\DB;
use Exception;

class BookingService
{
    public function bookSeat($userId, $scheduleId, $seatId)
    {
        return DB::transaction(function () use ($userId, $scheduleId, $seatId) {

            $seat = Seat::lockForUpdate()->findOrFail($seatId);

            if (! $seat->isAvailableForSchedule($scheduleId)) {
                throw new Exception('Kursi sudah dibooking');
            }
            $booking = Booking::create([
                'user_id' => $userId,
                'schedule_id' => $scheduleId,
                'status' => 'pending',
                'total_price' => $seat->bus->schedules()
                    ->where('id', $scheduleId)
                    ->value('price'),
            ]);
            BookingSeat::create([
                'booking_id' => $booking->id,
                'seat_id' => $seat->id,
            ]);

            return $booking;
        });
    }
}
