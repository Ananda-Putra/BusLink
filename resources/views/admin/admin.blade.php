@extends('admin.layout') 
@section('header', 'Dashboard Utama')
@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
            <p class="text-gray-500 font-bold text-sm">TOTAL BUS</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-1">12</h3>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
            <p class="text-gray-500 font-bold text-sm">TIKET TERJUAL</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-1">45</h3>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
            <p class="text-gray-500 font-bold text-sm">PENDAPATAN</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-1">Rp 4.5jt</h3>
        </div>
    </div>

    <div class="bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Halo, Admin! 👋</h2>
        <p class="text-gray-600">
            Selamat datang di panel kontrol. Silakan pilih menu 
            <a href="{{ route('admin.buses.index') }}" class="text-blue-600 font-bold hover:underline">Kelola Bus</a> 
            di samping kiri untuk mulai bekerja.
        </p>
    </div>
@endsection