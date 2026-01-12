<div class="drawer-side is-drawer-close:overflow-visible">
    <label for="my-drawer-4" aria-label="close sidebar" class="drawer-overlay"></label>

    <div class="flex min-h-full flex-col bg-base-200
                w-64 is-drawer-close:w-14 is-drawer-open:w-80">

        {{-- LOGO --}}
        <div class="flex items-center justify-center p-4">
            <img src="{{ asset('storage/logo_bengkod.svg') }}" class="w-30 h-auto transition-all duration-300" alt="Logo">
        </div>

        {{-- MENU --}}
        <ul class="menu w-full grow gap-1 px-2">

            {{-- Dashboard --}}
            <li class="{{ request()->routeIs('dashboard') ? 'bg-gray-200 rounded-lg' : '' }}">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3
                          is-drawer-close:tooltip is-drawer-close:tooltip-right"
                    data-tip="Dashboard">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 9l9-7 9 7v11a2 2 0 01-2 2h-4a2 2 0 01-2-2V12H9v8a2 2 0 01-2 2H3z" />
                    </svg>

                    <span class="is-drawer-close:hidden">Dashboard</span>
                </a>
            </li>

            {{-- Manajemen Kategori --}}
            <li class="{{ request()->routeIs('categories.*') ? 'bg-gray-200 rounded-lg' : '' }}">
                <a href="{{ route('categories.index') }}"
                    class="flex items-center gap-3
                          is-drawer-close:tooltip is-drawer-close:tooltip-right"
                    data-tip="Manajemen Kategori">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                    </svg>

                    <span class="is-drawer-close:hidden">Manajemen Kategori</span>
                </a>
            </li>

            {{-- Manajemen Event --}}
            <li class="{{ request()->routeIs('events.*') ? 'bg-gray-200 rounded-lg' : '' }}">
                <a href="{{ route('events.index') }}"
                    class="flex items-center gap-3
                          is-drawer-close:tooltip is-drawer-close:tooltip-right"
                    data-tip="Manajemen Event">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 4H5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V6a2 2 0 00-2-2h-4" />
                    </svg>

                    <span class="is-drawer-close:hidden">Manajemen Event</span>
                </a>
            </li>

            {{-- History Pembelian --}}
            <li class="{{ request()->routeIs('transactions.*') ? 'bg-gray-200 rounded-lg' : '' }}">
                <a href="{{ route('transactions.index') }}"
                    class="flex items-center gap-3
                          is-drawer-close:tooltip is-drawer-close:tooltip-right"
                    data-tip="History Pembelian">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    <span class="is-drawer-close:hidden">History Pembelian</span>
                </a>
            </li>
        </ul>

        {{-- LOGOUT --}}
        <div class="p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="btn btn-outline btn-error w-full
                               is-drawer-close:tooltip is-drawer-close:tooltip-right"
                    data-tip="Logout">

                    <svg class="w-5 h-5" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M10 17v-2h4v-2h-4v-2l-5 3l5 3m9-12H5q-.825 0-1.413.588T3 7v10q0 .825.587 1.413T5 19h14q.825 0 1.413-.587T21 17v-3h-2v3H5V7h14v3h2V7q0-.825-.587-1.413T19 5z" />
                    </svg>

                    <span class="is-drawer-close:hidden">Logout</span>
                </button>
            </form>
        </div>

    </div>
</div>