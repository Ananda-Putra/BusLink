@extends('admin.layout')
@section('header', 'Kelola Data Bus')

@section('content')

    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h3 class="text-lg font-bold mb-4 text-gray-700">Tambah Bus Baru</h3>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.buses.store') }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end">
            @csrf
            
            <div class="flex-1 w-full">
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Bus / Plat Nomor</label>
                <input type="text" name="bus_name" class="w-full border border-gray-300 p-2 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Sinar Jaya (B 1234 XX)" required>
            </div>

            <div class="w-full md:w-32">
                <label class="block text-sm font-bold text-gray-700 mb-1">Total Kursi</label>
                <input type="number" name="total_seats" class="w-full border border-gray-300 p-2 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="40" required>
            </div>

            <button type="submit" class="w-full md:w-auto bg-blue-600 text-white px-6 py-2 rounded font-bold hover:bg-blue-700 transition">
                + Simpan
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="font-bold text-gray-700">Daftar Armada Bus</h3>
        </div>
        
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">No</th>
                    <th class="py-3 px-6 text-left">Nama Bus</th>
                    <th class="py-3 px-6 text-center">Kapasitas Kursi</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($buses as $index => $bus)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $index + 1 }}</td>
                    <td class="py-3 px-6 text-left font-medium">{{ $bus->bus_name }}</td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-blue-100 text-blue-600 py-1 px-3 rounded-full text-xs font-bold">
                            {{ $bus->total_seats }} Kursi
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <form action="{{ route('admin.buses.destroy', $bus->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus bus ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transform hover:scale-110 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-6 px-6 text-center text-gray-500 bg-gray-50">
                        Belum ada data bus. Silakan tambah di atas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection