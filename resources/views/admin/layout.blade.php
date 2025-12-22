<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin TravelBus</title>
    {{-- Memanggil CSS Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-slate-800 text-white flex flex-col hidden md:flex">
            <div class="h-16 flex items-center justify-center border-b border-slate-700 shadow-lg">
                <h1 class="text-2xl font-bold text-blue-400 tracking-wider">TravelBus</h1>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                
                <a href="{{ route('admin.admin') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.buses.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.buses.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    Kelola Bus
                </a>

                <a class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:text-gray-100 {{ request()->routeIs('admin.routes.*') ? 'bg-gray-700 text-gray-100' : '' }}"
                    href="{{ route('admin.routes.index') }}">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.553-.894L15 7m0 13V7" />
                    </svg>
                    <span class="mx-3">Kelola Rute</span>
                </a>

                <a class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:text-gray-100 {{ request()->routeIs('admin.schedules.*') ? 'bg-gray-700 text-gray-100' : '' }}"
                    href="{{ route('admin.schedules.index') }}">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="mx-3">Jadwal & Harga</span>
                </a>

            </nav>

            <div class="p-4 border-t border-slate-700">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition font-semibold flex justify-center items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-y-auto">
            
            <header class="bg-white shadow h-16 flex items-center justify-between px-6 z-10">
                <h2 class="text-xl font-bold text-gray-800">
                    @yield('header', 'Dashboard') </h2>

                <div class="flex items-center space-x-4">
                    <span class="text-gray-600 font-medium">Halo, {{ Auth::user()->name }}</span>
                    <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold border border-blue-200">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <main class="p-6">
                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>