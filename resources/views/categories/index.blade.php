@extends('layouts.admin_layouts')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="container mx-auto py-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manajemen Kategori</h1>
        <button onclick="openForm()" class="btn btn-primary">Tambah Kategori</button>
    </div>

    <table class="table w-full border border-gray-200 rounded-lg">
        <thead>
            <tr class="bg-gray-100 text-center">
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $index => $category)
            <tr class="border-t text-center">
                <td>{{ $index + 1 }}</td>
                <td>{{ $category->nama }}</td>
                <td class="flex justify-center gap-2">
                    <button
                        onclick="openForm({{ $category->id }}, '{{ $category->nama }}')"
                        class="btn btn-sm btn-primary">
                        Edit
                    </button>

                    <button
                        onclick="hapusKategori({{ $category->id }})"
                        class="btn btn-sm btn-error">
                        Hapus
                    </button>

                    <form id="hapus-{{ $category->id }}"
                        action="{{ route('categories.destroy', $category->id) }}"
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
            <h2 id="formTitle" class="font-bold mb-3">Tambah Kategori</h2>

            <form id="categoryForm" method="POST">
                @csrf
                <input type="text" name="nama" id="namaInput"
                    class="input input-bordered w-full mb-3"
                    placeholder="Nama Kategori" required>

                <div class="flex justify-end gap-2">
                    <button type="button" id="submitBtn" onclick="konfirmasiSimpan()" class="btn btn-primary btn-sm">
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
        const form = document.getElementById('categoryForm');
        const title = document.getElementById('formTitle');
        const namaInput = document.getElementById('namaInput');
        const submitBtn = document.getElementById('submitBtn');

        const method = form.querySelector('input[name="_method"]');
        if (method) method.remove();

        if (id) {
            title.textContent = 'Edit Kategori';
            namaInput.value = nama;
            form.action = `/categories/${id}`;

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_method';
            input.value = 'PUT';
            form.appendChild(input);

            submitBtn.textContent = 'Update';
        } else {
            title.textContent = 'Tambah Kategori';
            namaInput.value = '';
            form.action = `/categories`;
            submitBtn.textContent = 'Simpan';
        }

        modal.classList.remove('hidden');
    }

    function closeForm() {
        document.getElementById('modalForm').classList.add('hidden');
    }

    function hapusKategori(id) {
        Swal.fire({
            title: 'Yakin?',
            text: 'Data kategori akan dihapus',
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
            text: 'Yakin ingin menyimpan data kategori?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('categoryForm').submit();
            }
        });
    }
</script>

@endsection