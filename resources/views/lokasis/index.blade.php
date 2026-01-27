@extends('layouts.admin_layouts')

@section('title', 'Manajemen Lokasi')

@section('content')
<div class="container mx-auto py-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manajemen Lokasi</h1>
        <button onclick="openForm()" class="btn btn-primary">Tambah Lokasi</button>
    </div>

    <table class="table w-full border border-gray-200 rounded-lg">
        <thead>
            <tr class="bg-gray-100 text-center">
                <th>No</th>
                <th>Nama Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lokasis as $index => $lokasi)
            <tr class="border-t text-center">
                <td>{{ $index + 1 }}</td>
                <td>{{ $lokasi->nama_lokasi }}</td>
                <td class="flex justify-center gap-2">
                    <button
                        onclick="openForm({{ $lokasi->id }}, '{{ $lokasi->nama_lokasi }}')"
                        class="btn btn-sm btn-primary">
                        Edit
                    </button>

                    <button
                        onclick="hapusLokasi({{ $lokasi->id }})"
                        class="btn btn-sm btn-error">
                        Hapus
                    </button>

                    <form id="hapus-{{ $lokasi->id }}"
                        action="{{ route('lokasis.destroy', $lokasi->id) }}"
                        method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- MODAL -->
    <div id="modalForm"
        class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50">
        <div class="bg-white p-4 rounded shadow-lg w-1/3">
            <h2 id="formTitle" class="font-bold mb-3">Tambah Lokasi</h2>

            <form id="lokasiForm" method="POST">
                @csrf
                <input type="text" name="nama_lokasi" id="namaInput"
                    class="input input-bordered w-full mb-3"
                    placeholder="Nama Lokasi" required>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="konfirmasiSimpan()"
                        class="btn btn-primary btn-sm">
                        Simpan
                    </button>
                    <button type="button" onclick="closeForm()"
                        class="btn btn-secondary btn-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function openForm(id = null, nama = '') {
    const modal = document.getElementById('modalForm');
    const form = document.getElementById('lokasiForm');
    const title = document.getElementById('formTitle');
    const namaInput = document.getElementById('namaInput');

    const method = form.querySelector('input[name="_method"]');
    if (method) method.remove();

    if (id) {
        title.textContent = 'Edit Lokasi';
        namaInput.value = nama;
        form.action = `/lokasis/${id}`;

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = '_method';
        input.value = 'PUT';
        form.appendChild(input);
    } else {
        title.textContent = 'Tambah Lokasi';
        namaInput.value = '';
        form.action = `/lokasis`;
    }

    modal.classList.remove('hidden');
}

function closeForm() {
    document.getElementById('modalForm').classList.add('hidden');
}

function hapusLokasi(id) {
    Swal.fire({
        title: 'Yakin?',
        text: 'Data lokasi akan dihapus',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('hapus-' + id).submit();
        }
    });
}

function konfirmasiSimpan() {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Yakin ingin menyimpan data lokasi?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, simpan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('lokasiForm').submit();
        }
    });
}
</script>
@endsection
