@extends('layouts.admin_layouts')

@section('title', 'Edit Kategori')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Kategori</h1>

@if ($errors->any())
<div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
    <ul>
        @foreach ($errors->all() as $error)
        <li>- {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block mb-1">Nama Kategori</label>
        <input type="text" name="nama" class="input input-bordered w-full" value="{{ old('nama', $category->nama) }}"
            required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection