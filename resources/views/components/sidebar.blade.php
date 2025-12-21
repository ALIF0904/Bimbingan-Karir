<div class="w-64 bg-base-200 min-h-screen flex flex-col justify-between">
    {{-- Bagian atas: logo + menu --}}
    <div>
        {{-- Logo --}}
        <div class="w-full flex items-center justify-center p-4">
            <img src="{{ asset('storage/logo_bengkod.svg') }}" alt="Logo" class="w-32">
        </div>

        {{-- Menu --}}
        <ul class="menu w-full grow">
            {{-- Dashboard --}}
            <li class="{{ request()->routeIs('dashboard') ? 'bg-gray-200 rounded-lg' : '' }}">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 p-2 hover:bg-gray-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor">
                        <path d="M6 19h3v-5q0-.425.288-.712T10 13h4q.425 0 .713.288T15 14v5h3v-9l-6-4.5L6 10zm-2 0v-9q0-.475.213-.9t.587-.7l6-4.5q.525-.4 1.2-.4t1.2.4l6 4.5q.375.275.588.7T20 10v9q0 .825-.588 1.413T18 21h-4q-.425 0-.712-.288T13 20v-5h-2v5q0 .425-.288.713T10 21H6q-.825 0-1.412-.587T4 19m8-6.75" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Kategori --}}
            <li class="{{ request()->routeIs('categories.*') ? 'bg-gray-200 rounded-lg' : '' }}">
                <a href="{{ route('categories.index') }}" class="flex items-center gap-2 p-2 hover:bg-gray-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="4" width="6" height="6"></rect>
                        <rect x="14" y="4" width="6" height="6"></rect>
                        <rect x="4" y="14" width="6" height="6"></rect>
                        <circle cx="16" cy="16" r="3"></circle>
                    </svg>
                    <span>Manajemen Kategori</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- Bagian bawah: Logout --}}
    <div class="p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-2 w-full p-2 text-white font-bold bg-red-500 hover:bg-red-600 rounded-lg">
                <!-- Icon pintu keluar -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>