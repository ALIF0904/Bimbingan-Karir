@extends('layouts.admin_layouts')

@section('title', 'Manajemen Tipe Tiket')

@section('content')
<div class="container mx-auto py-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manajemen Tipe Tiket</h1>
        <button onclick="openForm()" class="btn btn-primary">Tambah</button>
    </div>

    <table class="table w-full border">
        <thead class="bg-gray-100 text-center">
            <tr>
                <th>No</th>
                <th>Nama Tipe Tiket</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($types as $i => $type)
            <tr class="border-t text-center">
                <td>{{ $i + 1 }}</td>
                <td>{{ $type->tipe_tiket }}</td>
                <td class="flex justify-center gap-2">

                    <button class="btn btn-sm btn-primary"
                        onclick='openForm({{ $type->id }}, @json($type->tipe_tiket))'>
                        Edit
                    </button>

                    <form id="hapus-{{ $type->id }}"
                        action="{{ route('types.destroy', $type->id) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            onclick="hapusType({{ $type->id }})"
                            class="btn btn-sm btn-error">
                            Hapus
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- MODAL --}}
<div id="modalForm" class="fixed inset-0 bg-black/40 hidden z-50 flex items-center justify-center">
    <div class="bg-white p-4 rounded w-1/3">
        <h2 id="formTitle" class="font-bold mb-3">Tambah Tipe Tiket</h2>

        <form id="typeForm" method="POST">
            @csrf
            <input type="text"
                name="tipe_tiket"
                id="tipeTiketInput"
                class="input input-bordered w-full mb-3"
                placeholder="Nama Tipe Tiket"
                required>

            <div class="flex justify-end gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                <button type="button" onclick="closeForm()" class="btn btn-secondary btn-sm">Batal</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function openForm(id = null, nama = '') {
        const modal = document.getElementById('modalForm');
        const form = document.getElementById('typeForm');
        const title = document.getElementById('formTitle');
        const namaInput = document.getElementById('tipeTiketInput');

        form.querySelector('input[name="_method"]')?.remove();

        if (id) {
            title.innerText = 'Edit Tipe Tiket';
            namaInput.value = nama;
            form.action = `/types/${id}`;
            form.insertAdjacentHTML('beforeend',
                `<input type="hidden" name="_method" value="PUT">`);
        } else {
            title.innerText = 'Tambah Tipe Tiket';
            namaInput.value = '';
            form.action = `/types`;
        }

        modal.classList.remove('hidden');
    }

    function closeForm() {
        document.getElementById('modalForm').classList.add('hidden');
    }

    function hapusType(id) {
        Swal.fire({
            title: 'Yakin hapus?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus'
        }).then(res => {
            if (res.isConfirmed) {
                document.getElementById('hapus-' + id).submit();
            }
        });
    }
</script>
@endsection