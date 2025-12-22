<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TravelBus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-600">TravelBus</h1>
            <p class="text-gray-500 mt-2">Masuk untuk mulai memesan tiket</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 border-gray-300" placeholder="nama@email.com" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 border-gray-300" placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-200">
                Masuk Sekarang
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Daftar disini</a>
        </p>
    </div>

</body>
</html>