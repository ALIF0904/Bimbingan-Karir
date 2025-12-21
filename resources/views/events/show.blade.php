@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12">
    <h1 class="text-3xl font-bold mb-4">{{ $event->judul }}</h1>
    <img src="{{ asset('storage/' . $event->gambar) }}" alt="{{ $event->judul }}" class="mb-4 w-full max-h-96 object-cover rounded">
    <p class="mb-2"><strong>Tanggal & Waktu:</strong> {{ $event->tanggal_waktu }}</p>
    <p class="mb-2"><strong>Lokasi:</strong> {{ $event->lokasi }}</p>
    <p class="mb-4"><strong>Deskripsi:</strong></p>
    <p>{{ $event->deskripsi }}</p>
    <a href="{{ route('home') }}" class="mt-4 inline-block text-blue-600 hover:underline">Kembali ke daftar event</a>
</div>
@endsection
