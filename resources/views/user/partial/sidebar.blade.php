    <div class="drawer-side">
        <label for="my-drawer-4" class="drawer-overlay"></label>

        <div class="w-64 bg-slate-800 text-slate-100 min-h-screen flex flex-col justify-between">

            {{-- ATAS --}}
            <div>
                <div class="p-4 border-b border-slate-700 text-center">
                    <span class="text-2xl font-bold">BengTix</span>
                </div>

                {{-- MENU --}}
                <ul class="p-3 space-y-1">

                    {{-- Dashboard --}}
                    <li class="{{ request()->routeIs('user.dashboard') ? 'bg-slate-700 rounded-lg' : '' }}">
                        <a href="{{ route('user.dashboard') }}"
                            class="flex items-center gap-2 p-2 rounded text-slate-100 no-underline hover:bg-slate-700 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 9l9-7 9 7v11a2 2 0 01-2 2h-4a2 2 0 01-2-2V12H9v8a2 2 0 01-2 2H3z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    {{-- Event --}}
                    <li class="{{ request()->routeIs('user.event.*') ? 'bg-slate-700 rounded-lg' : '' }}">
                        <a href="{{ route('user.event.index') }}"
                            class="flex items-center gap-2 p-2 rounded text-slate-100 no-underline hover:bg-slate-700 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 4H5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V6a2 2 0 00-2-2h-4" />
                            </svg>
                            <span>Event</span>
                        </a>
                    </li>

                    {{-- Riwayat --}}
                    <li class="{{ request()->routeIs('user.riwayat.*') ? 'bg-slate-700 rounded-lg' : '' }}">
                        <a href="{{ route('user.riwayat.index') }}"
                            class="flex items-center gap-2 p-2 rounded text-slate-100 no-underline hover:bg-slate-700 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0" />
                            </svg>
                            <span>Riwayat Pembelian</span>
                        </a>
                    </li>

                </ul>
            </div>

            {{-- BAWAH --}}
            <div class="p-4">
                <p class="text-sm mb-3">{{ auth()->user()->name }}</p>

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