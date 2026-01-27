@extends('layouts.admin_layouts')

@section('title', 'Edit Lokasi')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Lokasi</h1>

@if ($errors->any()) <!-- Menghindari data tidak valid masuk database -->
<div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
    <ul>
        @foreach ($errors->all() as $error)
        <li>- {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('lokasis.update', $lokasi->id) }}"
      method="POST"
      class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block mb-1">Nama Lokasi</label>
        <input type="text"
            name="nama_lokasi"
            class="input input-bordered w-full"
            value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}"
            required>
    </div>

    <button type="submit" class="btn btn-primary">
        Update
    </button>
</form>
@endsection
