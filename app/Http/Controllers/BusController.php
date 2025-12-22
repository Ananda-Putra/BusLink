<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::all();
        
        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        return view('admin.buses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bus_name' => 'required', 
            'total_seats' => 'required|numeric',
        ]);

        Bus::create([
            'bus_name' => $request->bus_name, 
            'total_seats' => $request->total_seats,
        ]);
        return redirect()->route('admin.buses.index')->with('success', 'Data bus berhasil disimpan!');
    }
    }