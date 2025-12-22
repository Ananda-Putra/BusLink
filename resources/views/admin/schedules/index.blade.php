@extends('admin.layout')
@section('header', 'Atur Jadwal & Harga Tiket')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="bg-white p-6 rounded-lg shadow-lg h-fit">
        <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Buat Jadwal Baru</h3>
        
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.schedules.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Armada Bus</label>
                <select name="bus_id" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5" required>
                    <option value="">-- Pilih Bus --</option>
                    @foreach($buses as $bus)
                        <option value="{{ $bus->id }}">{{ $bus->bus_name }} ({{ $bus->total_seats }} Kursi)</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Rute Perjalanan</label>
                <select name="route_id" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5" required>
                    <option value="">-- Pilih Rute --</option>
                    @foreach($routes as $route)
                        <option value="{{ $route->id }}">{{ $route->origin }} -> {{ $route->destination }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Keberangkatan</label>
                <input type="datetime-local" name="depart_time" class="w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5" required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Tiket (Rp)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 font-bold">Rp</span>
                    </div>
                    <input type="number" name="price" class="pl-10 w-full bg-gray-50 border border-gray-300 rounded-lg p-2.5 font-bold text-green-700" placeholder="0" required>
                </div>
            </div>

            <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-3 text-center">
                Simpan Jadwal
            </button>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="font-bold text-gray-700">Daftar Jadwal Aktif</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-blue-50 text-blue-800 uppercase text-xs font-bold">
                    <tr>
                        <th class="py-3 px-4">Info Bus</th>
                        <th class="py-3 px-4">Rute</th>
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4 text-right">Harga</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($schedules as $schedule)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 font-medium">
                            {{ $schedule->bus->bus_name }}
                        </td>
                        
                        <td class="py-3 px-4">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                {{ $schedule->route->origin }}
                            </span>
                            <span class="text-gray-400">➜</span>
                            <span class="bg-green-100 text-green-800 text-xs font-semibold ml-2 px-2.5 py-0.5 rounded">
                                {{ $schedule->route->destination }}
                            </span>
                        </td>

                        <td class="py-3 px-4">
                            {{ \Carbon\Carbon::parse($schedule->depart_time)->format('d M Y, H:i') }} WIB
                        </td>

                        <td class="py-3 px-4 text-right font-bold text-green-600">
                            Rp {{ number_format($schedule->price, 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-400">
                            Belum ada jadwal Keberangkatan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection