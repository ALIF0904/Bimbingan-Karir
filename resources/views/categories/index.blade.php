@extends('layouts.admin_layouts')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="container mx-auto py-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manajemen Kategori</h1>
        <button onclick="openForm()" class="btn btn-primary">Tambah Kategori</button>
    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
        {{ session('success') }}
    </div>
    @endif

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
            <tr class="border-t border-gray-200 text-center">
                <td>{{ $index + 1 }}</td>
                <td>{{ $category->nama }}</td>
                <td class="flex justify-center items-center gap-2">
                    <button onclick="openForm({{ $category->id }}, '{{ $category->nama }}')" class="btn btn-sm btn-primary">Edit</button>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded btn-sm">
                            Hapus
                        </button>

                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Form -->
    <div id="modalForm" class="absolute inset-0 flex items-center justify-center hidden z-50 pointer-events-none">
        <div class="bg-white p-4 rounded shadow-lg w-1/4 pointer-events-auto">
            <h2 id="formTitle" class="text-lg font-bold mb-3">Tambah Kategori</h2>

            <form id="categoryForm" method="POST">
                @csrf
                <input type="text" name="nama" id="namaInput" class="input input-bordered w-full mb-3 text-sm" placeholder="Nama Kategori" required>

                <div class="flex justify-end gap-2">
                    <button type="submit" class="btn btn-sm btn-primary" id="submitBtn">Simpan</button>
                    <button type="button" onclick="closeForm()" class="btn btn-sm btn-secondary">Batal</button>
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

        if (id) {
            // Edit
            title.textContent = 'Edit Kategori';
            namaInput.value = nama;
            form.action = `/categories/${id}`; // route update
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
            submitBtn.textContent = 'Update';
        } else {
            // Tambah
            title.textContent = 'Tambah Kategori';
            namaInput.value = '';
            form.action = `/categories`; // route store
            // hapus input _method jika ada
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();
            submitBtn.textContent = 'Simpan';
        }

        modal.classList.remove('hidden');
    }

    function closeForm() {
        document.getElementById('modalForm').classList.add('hidden');
    }
</script>

@endsection