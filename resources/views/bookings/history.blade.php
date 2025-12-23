<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Perjalanan - BusLink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-bold text-blue-600">
                        <i class="fas fa-bus"></i> BusLink
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 font-medium text-sm transition">
                        Cari Tiket
                    </a>
                    <a href="{{ route('bookings.index') }}" class="text-blue-600 font-bold text-sm border-b-2 border-blue-600 pb-1">
                        Riwayat
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-medium hover:bg-red-100 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Riwayat Perjalanan</h2>
                <p class="text-gray-500 text-sm mt-1">Daftar tiket bus yang pernah kamu pesan.</p>
            </div>

            @if($bookings->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-10 text-center border border-gray-100">
                    <div class="mx-auto h-20 w-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-ticket-alt text-3xl text-blue-500"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada riwayat</h3>
                    <p class="mt-2 text-gray-500 text-sm">Kamu belum memesan tiket apapun.</p>
                    <a href="{{ route('home') }}" class="mt-6 inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Pesan Sekarang
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($bookings as $booking)
                        <div class="bg-white shadow-sm hover:shadow-md rounded-xl border border-gray-100 overflow-hidden transition-all duration-300">
                            
                            <div class="bg-gray-50 px-6 py-3 border-b border-gray-100 flex justify-between items-center">
                                <div class="text-xs text-gray-500">
                                    <span class="font-bold">#{{ $booking->booking_code ?? $booking->id }}</span>
                                    <span class="mx-2">•</span>
                                    {{ $booking->created_at->format('d M Y') }}
                                </div>
                                <div>
                                    @if($booking->status == 'paid')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                            LUNAS
                                        </span>
                                    @elseif($booking->status == 'pending')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200 animate-pulse">
                                            MENUNGGU BAYAR
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                            BATAL
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                                    
                                    <div class="flex-1 w-full">
                                        <div class="flex items-center gap-2 mb-4">
                                            <i class="fas fa-bus text-blue-600"></i>
                                            <h4 class="font-bold text-gray-800 text-lg">{{ $booking->schedule->bus->bus_name ?? $booking->schedule->bus->name }}</h4>
                                        </div>

                                        <div class="flex items-center justify-between text-center md:text-left">
                                            <div>
                                                <p class="text-xl font-bold text-gray-900">{{ \Carbon\Carbon::parse($booking->schedule->depart_time)->format('H:i') }}</p>
                                                <p class="text-sm font-medium text-gray-600">{{ $booking->schedule->route->origin }}</p>
                                            </div>
                                            
                                            <div class="flex-1 px-4 flex flex-col items-center">
                                                <div class="w-full h-[2px] bg-gray-300 relative">
                                                    <div class="absolute right-0 -top-1 w-2 h-2 bg-gray-400 rounded-full"></div>
                                                </div>
                                                <span class="text-xs text-gray-400 mt-1">Perjalanan</span>
                                            </div>

                                            <div>
                                                <p class="text-xl font-bold text-gray-900">--:--</p>
                                                <p class="text-sm font-medium text-gray-600">{{ $booking->schedule->route->destination }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-full md:w-auto border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6 text-center md:text-right">
                                        <p class="text-xs text-gray-500 mb-1">Total Bayar</p>
                                        <p class="text-2xl font-bold text-blue-600 mb-4">
                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </p>

                                        @if($booking->status == 'pending')
                                            <form action="{{ route('bookings.pay', $booking->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full inline-block px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                                                    Bayar Sekarang
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('bookings.show', $booking->id) }}" class="inline-block px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                                                Lihat Tiket
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
    </body>
</html>