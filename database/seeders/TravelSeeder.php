<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Route;
use App\Models\Bus;
use App\Models\Seat;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class TravelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Route
        $route = Route::create([
            'origin' => 'Jakarta',
            'destination' => 'Bandung'
        ]);

        // Bus
        $bus = Bus::create([
            'bus_name' => 'Bus Maju Jaya',
            'total_seats' => 5
        ]);

        // Seats
        for ($i = 1; $i <= 5; $i++) {
            Seat::create([
                'bus_id' => $bus->id,
                'seat_number' => 'A' . $i,
                'is_active' => true
            ]);
        }

        // Schedule
        Schedule::create([
            'route_id' => $route->id,
            'bus_id' => $bus->id,
            'depart_time' => now()->addDay(),
            'price' => 150000
        ]);
        
    }
}
