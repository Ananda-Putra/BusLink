<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Bus;
use App\Models\Route;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['bus', 'route'])->latest()->get();
        $buses = Bus::all();
        $routes = Route::all();

        return view('admin.schedules.index', compact('schedules', 'buses', 'routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bus_id' => 'required',
            'route_id' => 'required',
            'depart_time' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);

        Schedule::create([
            'bus_id' => $request->bus_id,
            'route_id' => $request->route_id,
            'depart_time' => $request->depart_time,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Jadwal dan Harga berhasil disimpan!');
    }

    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Jadwal dihapus.');
    }
}