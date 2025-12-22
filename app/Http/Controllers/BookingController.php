<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookingService;
use Exception;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * POST /booking
     * Body: { "user_id": 1, "schedule_id": 1, "seat_id": 1 }
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'schedule_id' => 'required|exists:schedules,id',
            'seat_id' => 'required|exists:seats,id',
        ]);

        try {
            // Panggil service layer untuk booking
            $booking = $this->bookingService->bookSeat(
                $request->user_id,
                $request->schedule_id,
                $request->seat_id
            );

            return response()->json([
                'success' => true,
                'booking' => $booking
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 409);
        }
    }
}
