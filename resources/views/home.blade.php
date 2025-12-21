@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12">
    <h2 class="text-2xl font-bold mb-6">Event</h2>

    <div class="flex gap-2 mb-6">
        <a href="{{ route('home') }}">
            <span class="px-3 py-1 bg-gray-200 rounded">{{ 'Semua' }}</span>
        </a>
        @foreach($categories as $kategori)
            <a href="{{ route('home', ['kategori' => $kategori->id]) }}">
                <span class="px-3 py-1 bg-gray-200 rounded {{ request('kategori') == $kategori->id ? 'bg-blue-500 text-white' : '' }}">
                    {{ $kategori->nama }}
                </span>
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($events as $event)
            <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg">
                <img src="{{ asset('storage/konser/' . $event->gambar) }}" alt="{{ $event->judul }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-bold">{{ $event->judul }}</h3>
                    <p class="text-sm text-gray-600">{{ $event->tanggal_waktu }}</p>
                    <p class="text-sm text-gray-600">{{ $event->lokasi }}</p>
                    <a href="{{ route('events.show', $event) }}" class="mt-2 inline-block text-blue-600 hover:underline">Lihat Detail</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
