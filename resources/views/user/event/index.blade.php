@extends('layouts.user')

@section('content')
<div class="container mx-auto py-8">

    <h2 class="text-2xl font-bold mb-6">Event</h2>

    {{-- Filter kategori --}}
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('user.event.index') }}">
            <span class="px-3 py-1 rounded
                {{ request('kategori') ? 'bg-gray-200' : 'bg-blue-500 text-white' }}">
                Semua
            </span>
        </a>

        @foreach($kategoris as $kategori)
        <a href="{{ route('user.event.index', ['kategori' => $kategori->id]) }}">
            <span class="px-3 py-1 rounded
                    {{ request('kategori') == $kategori->id ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                {{ $kategori->nama }}
            </span>
        </a>
        @endforeach
    </div>

    {{-- Grid event --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($events as $event)
        <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition">
            <div class="w-full aspect-[4/3]">
                <img
                    src="{{ asset('storage/konser/' . $event->gambar) }}"
                    alt="{{ $event->judul }}"
                    class="w-full h-full object-cover">
            </div>

            <div class="p-4">
                <h3 class="text-lg font-bold">{{ $event->judul }}</h3>
                <p class="text-sm text-gray-600">
                    {{ optional($event->tanggal_waktu)->format('d M Y H:i') }}
                </p>
                <p class="text-sm text-gray-600">{{ $event->lokasi }}</p>

                <a href="{{ route('user.event.show', $event->id) }}"
                    class="mt-2 inline-block text-blue-600 hover:underline">
                    Lihat Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection