@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12">
    <h1 class="text-3xl font-bold mb-4">{{ $event->judul }}</h1>

    <img src="{{ asset('storage/' . $event->gambar) }}"
         class="mb-4 w-full max-h-96 object-cover rounded">

    <p><strong>Tanggal:</strong>
        {{ $event->tanggal_waktu->format('d M Y H:i') }}
    </p>

    <p><strong>Lokasi:</strong>
        {{ $event->lokasi->nama_lokasi ?? '-' }}
    </p>

    <p class="mt-4">{{ $event->deskripsi }}</p>

    <a href="{{ route('home') }}" class="text-blue-600">← Kembali</a>
</div>
@endsection
