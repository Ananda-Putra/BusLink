<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AdminController; 
use App\Models\Schedule;
use App\Models\Booking;

Route::get('/', function (Request $request) {
    $query = Schedule::with(['bus', 'route']);

    if ($request->filled('origin')) {
        $query->whereHas('route', function($q) use ($request) {
            $q->where('origin', 'like', '%' . $request->origin . '%');
        });
    }

    if ($request->filled('destination')) {
        $query->whereHas('route', function($q) use ($request) {
            $q->where('destination', 'like', '%' . $request->destination . '%');
        });
    }

    if ($request->filled('date')) {
        $query->whereDate('depart_time', $request->date);
    }

    $schedules = $query->latest()->get();
    return view('welcome', compact('schedules'));

})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/admin', [AdminController::class, 'index'])->name('admin.admin');
    Route::resource('admin/routes', RouteController::class)
        ->names('admin.routes') 
        ->except(['create', 'edit', 'update']);
    Route::resource('admin/buses', BusController::class)->names('admin.buses');
    Route::get('/admin/routes', [RouteController::class, 'index'])->name('admin.routes.index');
    Route::post('/admin/routes', [RouteController::class, 'store'])->name('admin.routes.store');
    Route::delete('/admin/routes/{id}', [RouteController::class, 'destroy'])->name('admin.routes.destroy');
    Route::get('/admin/schedules', [ScheduleController::class, 'index'])->name('admin.schedules.index');
    Route::post('/admin/schedules', [ScheduleController::class, 'store'])->name('admin.schedules.store');
    Route::delete('/admin/schedules/{id}', [ScheduleController::class, 'destroy'])->name('admin.schedules.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/history', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/pay', [BookingController::class, 'payNow'])->name('bookings.pay');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');