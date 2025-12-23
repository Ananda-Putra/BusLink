<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelBus - Booking Tiket Mudah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans flex flex-col min-h-screen">

    <nav class="bg-white shadow-md fixed w-full z-20 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-blue-600 flex items-center gap-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        TravelBus
                    </a>
                </div>

                <div class="flex items-center space-x-6"> @auth
                        <span class="text-gray-700 hidden sm:block text-sm">
                            Halo, <strong>{{ Auth::user()->name }}</strong>
                        </span>

                        <a href="{{ route('bookings.index') }}" class="text-gray-600 hover:text-blue-600 font-bold text-sm flex items-center gap-1 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Riwayat
                        </a>
                        @if(Auth::user()->role === 'admin')
                             <a href="{{ route('admin.admin') }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm">Dashboard</a>
                        @endif
                        
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg text-sm font-medium transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition shadow-md">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="relative bg-blue-600 h-125 flex items-center justify-center pt-16">
        <div class="absolute inset-0 bg-linear-to-br from-blue-700 to-blue-500 opacity-90"></div>

        <div class="relative z-10 w-full max-w-4xl px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-white text-center mb-8 drop-shadow-md">
                Mau Pergi Ke Mana Hari Ini?
            </h1>

            <div class="bg-white p-6 rounded-xl shadow-2xl transform hover:scale-[1.01] transition duration-300">
                <form action="{{ route('home') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    
                    <div>
                        <label class="block text-gray-500 text-sm font-bold mb-1">Dari</label>
                        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 focus-within:ring-2 ring-blue-500">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <input type="text" name="origin" value="{{ request('origin') }}" placeholder="Kota Asal..." class="w-full bg-transparent outline-none text-gray-800">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm font-bold mb-1">Ke</label>
                        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 focus-within:ring-2 ring-blue-500">
                            <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <input type="text" name="destination" value="{{ request('destination') }}" placeholder="Kota Tujuan..." class="w-full bg-transparent outline-none text-gray-800">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm font-bold mb-1">Tanggal</label>
                        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 focus-within:ring-2 ring-blue-500">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <input type="date" name="date" value="{{ request('date') }}" class="w-full bg-transparent outline-none text-gray-800">
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-lg shadow-lg transition duration-200 flex justify-center items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Cari
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10 mb-12 grow">
        
        @if($schedules->isEmpty())
            <div class="bg-white rounded-lg shadow-lg p-10 text-center border-t-4 border-orange-500">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Jadwal Tidak Ditemukan</h3>
                <p class="text-gray-500">Coba ganti kata kunci pencarian atau tanggal keberangkatan.</p>
                <a href="/" class="text-blue-600 font-bold mt-4 inline-block hover:underline">Reset Pencarian</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($schedules as $item)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-300 flex flex-col h-full">
                    <div class="bg-gray-50 p-4 border-b border-gray-100 flex justify-between items-center">
                        <div class="flex items-center gap-2 text-gray-700 font-bold">
                            <span class="text-blue-600">{{ $item->route->origin }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            <span class="text-blue-600">{{ $item->route->destination }}</span>
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                            {{ \Carbon\Carbon::parse($item->depart_time)->format('H:i') }} WIB
                        </span>
                    </div>

                    <div class="p-5 grow">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-bold text-gray-800 text-lg">{{ $item->bus->bus_name }}</h4>
                                <p class="text-sm text-gray-500">{{ $item->bus->total_seats }} Kursi Available</p>
                            </div>
                            <div class="text-right">
                                <span class="block text-xs text-gray-500">Harga per kursi</span>
                                <span class="text-xl font-bold text-orange-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ \Carbon\Carbon::parse($item->depart_time)->translatedFormat('l, d F Y') }}
                        </div>
                    </div>

                    <div class="p-5 pt-0 mt-auto">
                        <form action="{{ url('/bookings') }}" method="POST">
                            @csrf
                            <input type="hidden" name="schedule_id" value="{{ $item->id }}">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-colors flex justify-center items-center gap-2 shadow-md">
                                <span>Pesan Tiket</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                    </div>

                </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="bg-white py-12 border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Kenapa Booking di TravelBus?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-4">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">💰</div>
                    <h3 class="font-bold text-lg mb-2">Harga Terbaik</h3>
                    <p class="text-gray-600 text-sm">Tiket termurah tanpa biaya aneh-aneh.</p>
                </div>
                <div class="text-center p-4">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">⚡</div>
                    <h3 class="font-bold text-lg mb-2">Cepat & Praktis</h3>
                    <p class="text-gray-600 text-sm">Booking kurang dari 2 menit.</p>
                </div>
                <div class="text-center p-4">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">🛡️</div>
                    <h3 class="font-bold text-lg mb-2">Aman Terpercaya</h3>
                    <p class="text-gray-600 text-sm">Pembayaran aman dan data terlindungi.</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>