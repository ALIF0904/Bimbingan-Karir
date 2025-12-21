<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BengTix' }}</title>
    @vite('resources/css/app.css') {{-- pastikan Vite/Tailwind aktif --}}
    @stack('styles') {{-- untuk tambahan CSS --}}
</head>
<body class="bg-gray-100 min-h-screen">
    
    {{-- Navbar --}}
    <nav class="bg-blue-900 text-white p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="font-bold text-xl">BengTix</a>
            <div class="flex gap-4 items-center">
                @auth
                    <span>{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-white font-bold">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-white text-blue-900 px-3 py-1 rounded font-bold hover:bg-gray-100">Login</a>

                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-600 px-3 py-1 rounded text-white font-bold">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    {{-- Konten --}}
    <main class="py-6">
        <div class="max-w-7xl mx-auto px-6">
            @yield('content')
        </div>
    </main>

    @stack('scripts') {{-- untuk tambahan JS --}}
</body>
</html>
