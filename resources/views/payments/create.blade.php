@extends('layouts.admin_layouts')

@section('title', 'Tambah Payment')

@section('content')
<div class="container mx-auto py-6 max-w-xl">

    <h1 class="text-2xl font-bold mb-4">Tambah Metode Pembayaran</h1>

    <form action="{{ route('payments.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1">Nama Payment</label>
            <input type="text"
                   name="nama"
                   class="input input-bordered w-full"
                   value="{{ old('nama') }}"
                   required>
        </div>

        <div>
            <label class="block mb-1">Tipe Payment</label>
            <select name="tipe" class="select select-bordered w-full" required>
                <option value="">-- Pilih --</option>
                <option value="bank" {{ old('tipe') == 'bank' ? 'selected' : '' }}>Bank</option>
                <option value="ewallet" {{ old('tipe') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                <option value="qris" {{ old('tipe') == 'qris' ? 'selected' : '' }}>QRIS</option>
            </select>
        </div>

        <div>
            <label class="block mb-1">Nomor Rekening / Wallet</label>
            <input type="text"
                   name="nomor"
                   class="input input-bordered w-full"
                   value="{{ old('nomor') }}">
        </div>

        <div>
            <label class="block mb-1">Atas Nama</label>
            <input type="text"
                   name="atas_nama"
                   class="input input-bordered w-full"
                   value="{{ old('atas_nama') }}">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   checked>
            <span>Aktifkan payment</span>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>
        </div>
    </form>

</div>
@endsection
