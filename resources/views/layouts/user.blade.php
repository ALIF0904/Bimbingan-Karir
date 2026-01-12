<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'BengTix - Pembeli')</title>

    {{-- Tailwind + DaisyUI --}}
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen bg-gray-100">

    <div class="drawer drawer-open">
        <!-- WAJIB -->
        <input id="my-drawer-4" type="checkbox" class="drawer-toggle" checked />

        <!-- SIDEBAR -->
        @include('user.partial.sidebar')

        <!-- KONTEN -->
        <div class="drawer-content p-6">
            @yield('content')
        </div>
    </div>

</body>
</html>
