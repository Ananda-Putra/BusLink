<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - TravelBus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        @media print {
            .no-print { display: none; }
            .print-area { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-6">

    <div class="print-area w-full max-w-3xl bg-white rounded-3xl shadow-2xl overflow-hidden relative">
        <div class="relative p-8 {{ $booking->status == 'paid' ? 'bg-linear-to-r from-emerald-500 to-teal-600' : 'bg-linear-to-r from-blue-600 to-indigo-700' }} text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">TravelBus</h1>
                    <p class="text-white/80 text-sm mt-1">E-Ticket / Boarding Pass</p>
                </div>
                <div class="px-4 py-1 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-sm font-semibold uppercase tracking-wider">
                    {{ $booking->status == 'paid' ? 'Lunas / Confirmed' : 'Menunggu Pembayaran' }}
                </div>
            </div>
            <div class="absolute -bottom-3 left-0 w-6 h-6 bg-gray-100 rounded-full translate-x-[-50%]"></div>
            <div class="absolute -bottom-3 right-0 w-6 h-6 bg-gray-100 rounded-full translate-x-[50%]"></div>
        </div>

        <div class="p-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
                <div class="text-center md:text-left">
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Berangkat</p>
                    <h2 class="text-4xl font-bold text-gray-800">{{ strtoupper($booking->schedule->route->origin) }}</h2>
                    <p class="text-indigo-600 font-semibold mt-1">
                        {{ \Carbon\Carbon::parse($booking->schedule->depart_time)->format('H:i') }} WIB
                    </p>
                </div>

                <div class="flex-1 px-6 flex flex-col items-center">
                    <div class="w-full border-t-2 border-dashed border-gray-300 relative top-3"></div>
                    <svg class="w-6 h-6 text-gray-400 bg-white px-1 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    <p class="text-xs text-gray-400 mt-2">{{ \Carbon\Carbon::parse($booking->schedule->depart_time)->format('d M Y') }}</p>
                </div>

                <div class="text-center md:text-right">
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Estimasi Tiba</p>
                    <h2 class="text-4xl font-bold text-gray-800">{{ strtoupper($booking->schedule->route->destination) }}</h2>
                    @php
                        $berangkat = \Carbon\Carbon::parse($booking->schedule->depart_time);
                        $durasi = $booking->schedule->route->duration; 
                        $sampai = $berangkat->copy()->addHours($durasi);
                    @endphp
                    <p class="text-indigo-600 font-semibold mt-1 text-xl">
                        {{ $sampai->format('H:i') }} WIB
                    </p>
                    <p class="text-xs text-gray-400">
                        (+{{ $durasi }} Jam Perjalanan)
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 bg-gray-50 p-6 rounded-xl border border-gray-100">
                <div>
                    <p class="text-xs text-gray-400 uppercase">Penumpang</p>
                    <p class="font-bold text-gray-800">{{ Auth::user()->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase">Armada Bus</p>
                    <p class="font-bold text-gray-800">{{ $booking->schedule->bus->bus_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase">Booking ID</p>
                    <p class="font-mono font-bold text-gray-800">{{ $booking->booking_code }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase">Harga</p>
                    <p class="font-bold text-emerald-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="relative flex items-center justify-between px-8">
            <div class="w-4 h-4 bg-gray-100 rounded-full -ml-10"></div>
            <div class="w-full border-t-2 border-dashed border-gray-300"></div>
            <div class="w-4 h-4 bg-gray-100 rounded-full -mr-10"></div>
        </div>

        <div class="p-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div id="qrcode" class="p-2 border rounded-lg bg-white"></div>
                <div class="text-sm text-gray-500">
                    <p>Scan kode ini saat</p>
                    <p>naik ke dalam bus.</p>
                </div>
            </div>

            <div class="w-full md:w-auto no-print">
                @if($booking->status == 'pending')
                    
                    <form action="{{ route('bookings.pay', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition transform hover:scale-105 cursor-pointer">
                            Bayar Sekarang
                        </button>
                    </form>

                @else
                    <div class="flex gap-3">
                        <button onclick="window.print()" class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl font-medium transition cursor-pointer">
                            🖨️ Cetak PDF
                        </button>
                        <a href="/" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition">
                            🏠 Home
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <p class="mt-6 text-gray-400 text-sm no-print">© 2024 TravelBus Indonesia</p>
    <script type="text/javascript">
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: "{{ $booking->booking_code }}",
            width: 100,
            height: 100,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    </script>
    
</body>
</html>