<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
                    ->with(['schedule.bus', 'schedule.route'])
                    ->latest()
                    ->get();
        return view('bookings.history', compact('bookings')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);
        $seats = $request->input('seats', 1); 
        $booking = Booking::create([
            'user_id'      => Auth::id(), 
            'schedule_id'  => $schedule->id,
            'booking_code' => 'TRX-' . strtoupper(Str::random(6)),
            'total_price'  => $schedule->price * $seats, 
            'seats'        => $seats, 
            'status'       => 'pending',
        ]);

        return redirect()->route('bookings.show', $booking->id);
    }

    public function show($id)
    {
        $booking = Booking::with(['schedule.bus', 'schedule.route'])
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);
        
        return view('bookings.show', compact('booking'));
    }

    public function payNow($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);
        $booking->update(['status' => 'paid']);
        return redirect()->route('bookings.show', $booking->id)
                         ->with('success', 'Pembayaran Berhasil! Tiket Terbit.');
    }
}