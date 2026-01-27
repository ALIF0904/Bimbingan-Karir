@extends('layouts.admin_layouts')

@section('title', 'Edit Payment')

@section('content')
<div class="container mx-auto py-6 max-w-xl">

    <h1 class="text-2xl font-bold mb-4">Edit Metode Pembayaran</h1>

    <form action="{{ route('payments.update', $payment->id) }}"
          method="POST"
          class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1">Nama Payment</label>
            <input type="text"
                   name="nama"
                   class="input input-bordered w-full"
                   value="{{ old('nama', $payment->nama) }}"
                   required>
        </div>

        <div>
            <label class="block mb-1">Tipe Payment</label>
            <select name="tipe" class="select select-bordered w-full" required>
                <option value="bank" {{ $payment->tipe == 'bank' ? 'selected' : '' }}>Bank</option>
                <option value="ewallet" {{ $payment->tipe == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                <option value="qris" {{ $payment->tipe == 'qris' ? 'selected' : '' }}>QRIS</option>
            </select>
        </div>

        <div>
            <label class="block mb-1">Nomor Rekening / Wallet</label>
            <input type="text"
                   name="nomor"
                   class="input input-bordered w-full"
                   value="{{ old('nomor', $payment->nomor) }}">
        </div>

        <div>
            <label class="block mb-1">Atas Nama</label>
            <input type="text"
                   name="atas_nama"
                   class="input input-bordered w-full"
                   value="{{ old('atas_nama', $payment->atas_nama) }}">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   {{ $payment->is_active ? 'checked' : '' }}>
            <span>Aktifkan payment</span>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                Update
            </button>
        </div>
    </form>

</div>
@endsection
