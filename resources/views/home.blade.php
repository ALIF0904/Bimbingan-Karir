@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">

    <h2 class="text-2xl font-bold mb-6">Event</h2>

    {{-- Filter kategori --}}
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('home') }}">
            <span
                class="px-3 py-1 rounded transition
                {{ request('kategori') ? 'bg-gray-200 text-gray-800' : 'bg-blue-500 text-white' }}">
                Semua
            </span>
        </a>

        @foreach($categories as $kategori)
        <a href="{{ route('home', ['kategori' => $kategori->id]) }}">
            <span
                class="px-3 py-1 rounded transition
                    {{ request('kategori') == $kategori->id
                        ? 'bg-blue-500 text-white'
                        : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                {{ $kategori->nama }}
            </span>
        </a>
        @endforeach
    </div>

    {{-- Grid Event --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($events as $event)
        <div class="border rounded-lg shadow hover:shadow-lg transition overflow-hidden bg-white">
            <img
                src="{{ asset('storage/konser/' . $event->gambar) }}"
                alt="{{ $event->judul }}"
                class="w-full h-48 object-cover rounded-t-lg">

            <div class="p-4 min-h-[150px] flex flex-col">
                <h3 class="text-lg font-semibold text-gray-800 line-clamp-2">
                    {{ $event->judul }}
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    {{ \Carbon\Carbon::parse($event->tanggal_waktu)->format('d M Y H:i') }}
                </p>

                <p class="text-sm text-gray-500">
                    {{ $event->lokasi }}
                </p>

                <a href="{{ route('events.show', $event->id) }}"
                    class="mt-auto inline-block text-blue-600 hover:underline text-sm font-medium">
                    Lihat Detail
                </a>
            </div>

        </div>
        @endforeach
    </div>

</div>
@endsection