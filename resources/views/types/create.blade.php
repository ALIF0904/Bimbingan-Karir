@extends('layouts.admin_layouts')

@section('title', 'Tambah Tipe Tiket')

@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Tipe Tiket</h1>

<form id="formTambahKategori"
    action="{{ route('types.store') }}"
    method="POST"
    class="space-y-4">
    @csrf

    <div>
        <label class="block mb-1">Nama Tipe Tiket</label>
        <input type="text"
            name="tipe_tiket"
            class="input input-bordered w-full"
            value="{{ old('tipe_tiket') }}"
            required>

    </div>

    <!-- tombol jadi BUTTON, bukan submit -->
    <button type="button"
        onclick="konfirmasiSimpan()"
        class="btn btn-primary"> <!--Mengurangi bug layout karena CSS custom berlebihan.-->
        Simpan
    </button>
</form>

{{-- SWEETALERT NOTIFIKASI --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: "{{ session('error') }}"
    });
</script>
@endif

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal',
        html: `{!! implode('<br>', $errors->all()) !!}`
    });
</script>
@endif

{{-- KONFIRMASI SIMPAN --}}
<script>
    function konfirmasiSimpan() {
        Swal.fire({
            title: 'Yakin?',
            text: 'Data type tiket akan disimpan',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formTambahKategori').submit();
            }
        });
    }
</script>
@endsection