@extends('layouts.admin_layouts')

@section('title', 'Manajemen Tiket')

@section('content')
<div class="container mx-auto py-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Tiket untuk : {{ $event->judul }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('events.index') }}" class="btn btn-sm">Kembali</a>
            <button onclick="openForm()" class="btn btn-sm btn-primary">Tambah Tiket</button>
        </div>
    </div>

    <table class="table w-full border border-gray-200 rounded-lg">
        <thead>
            <tr class="bg-gray-100 text-center">
                <th>No</th>
                <th>Tipe</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tikets as $i => $tiket)
            <tr class="border-t text-center">
                <td>{{ $i + 1 }}</td>
                <td>{{ $tiket->typeTiket?->tipe_tiket ?? '-' }}</td>
                <td>Rp {{ number_format($tiket->harga, 0, ',', '.') }}</td>
                <td>{{ $tiket->stok }}</td>
                <td class="flex justify-center gap-2">

                    <button
                        class="btn btn-sm btn-primary"
                        data-id="{{ $tiket->id }}"
                        data-type="{{ $tiket->type_tiket_id }}"
                        data-harga="{{ $tiket->harga }}"
                        data-stok="{{ $tiket->stok }}"
                        onclick="openFormFromBtn(this)">
                        Edit
                    </button>

                    <form action="{{ route('events.tikets.destroy', [$event->id, $tiket->id]) }}"
                          method="POST"
                          class="form-hapus inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-sm bg-red-600 text-white hover:bg-red-700">
                            Hapus
                        </button>
                    </form>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4">Belum ada tiket</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MODAL --}}
<div id="modalForm" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
        <h2 id="formTitle" class="text-lg font-bold mb-3">Tambah Tiket</h2>

        <form id="tiketForm" method="POST">
            @csrf

            <div class="mb-3">
                <label class="text-sm font-medium">Tipe Tiket</label>
                <select name="type_tiket_id" id="typeSelect"
                        class="input input-bordered w-full" required>
                    <option value="">-- Pilih Tipe Tiket --</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">
                            {{ $type->tipe_tiket }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="text-sm font-medium">Harga</label>
                <input type="number" name="harga" id="hargaInput"
                       class="input input-bordered w-full" required>
            </div>

            <div class="mb-4">
                <label class="text-sm font-medium">Stok</label>
                <input type="number" name="stok" id="stokInput"
                       class="input input-bordered w-full" required>
            </div>

            <div class="flex justify-end gap-2">
                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                <button type="button" onclick="closeForm()"
                        class="btn btn-sm btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const modal = document.getElementById('modalForm');
    const form  = document.getElementById('tiketForm');
    const typeSelect = document.getElementById('typeSelect');
    const hargaInput = document.getElementById('hargaInput');
    const stokInput  = document.getElementById('stokInput');

    // DELETE CONFIRM
    document.querySelectorAll('.form-hapus').forEach(formEl => {
        formEl.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin hapus tiket?',
                text: 'Data tidak bisa dikembalikan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) formEl.submit();
            });
        });
    });

    function resetMethod() {
        const method = form.querySelector('input[name="_method"]');
        if (method) method.remove();
    }

    function openFormFromBtn(btn) {
        openForm({
            id: btn.dataset.id,
            type: btn.dataset.type,
            harga: btn.dataset.harga,
            stok: btn.dataset.stok,
        });
    }

    function openForm(data = null) {
        resetMethod();

        if (data) {
            document.getElementById('formTitle').innerText = 'Edit Tiket';
            form.action = `/events/{{ $event->id }}/tikets/${data.id}`;

            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';
            form.appendChild(method);

            typeSelect.value = data.type;
            hargaInput.value = data.harga;
            stokInput.value  = data.stok;
        } else {
            document.getElementById('formTitle').innerText = 'Tambah Tiket';
            form.action = `/events/{{ $event->id }}/tikets`;
            form.reset();
        }

        modal.classList.remove('hidden');
    }

    function closeForm() {
        modal.classList.add('hidden');
    }
</script>
@endsection
