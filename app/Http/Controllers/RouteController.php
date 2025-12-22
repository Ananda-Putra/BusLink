<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route; 

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::all();
        return view('admin.routes.index', compact('routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
        ]);

        Route::create([
            'origin' => $request->origin,
            'destination' => $request->destination,
        ]);

        return redirect()->back()->with('success', 'Rute berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Route::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Rute dihapus.');
    }
}