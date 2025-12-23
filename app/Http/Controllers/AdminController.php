<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Booking;

class AdminController extends Controller
{
    public function index()
    {
        $totalBus = Bus::count();
        $tiketTerjual = Booking::where('status', 'paid')->count();
        $pendapatan = Booking::where('status', 'paid')->sum('total_price');
        return view('admin.admin', compact('totalBus', 'tiketTerjual', 'pendapatan'));
    }
}