@extends('layouts.admin_layouts')

@section('title', 'Dashboard Admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- Total Event --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <p class="text-gray-500 mb-2">Total Event</p>
        <h2 class="text-4xl font-bold">{{ $totalEvent }}</h2>
    </div>

    {{-- Total Kategori --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <p class="text-gray-500 mb-2">Kategori</p>
        <h2 class="text-4xl font-bold">{{ $totalKategori }}</h2>
    </div>

    {{-- Total Transaksi --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <p class="text-gray-500 mb-2">Total Transaksi</p>
        <h2 class="text-4xl font-bold">{{ $totalTransaksi }}</h2>
    </div>

</div>
@endsection
