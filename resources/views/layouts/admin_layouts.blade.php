<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Title dinamis --}}
    <title>@yield('title', 'My Laravel App')</title>
    
    {{-- Tailwind + DaisyUI --}}
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- Optional: Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="min-h-screen flex flex-col">

    <div class="flex flex-grow">
        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Konten halaman --}}
        <div class="flex-grow p-4">
            @yield('content')
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-light text-center py-3 mt-auto">
        <div class="container">
            <p>© {{ date('Y') }} MyLaravelApp. All rights reserved.</p>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
