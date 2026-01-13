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
            @foreach($tikets as $i => $tiket)
            <tr class="border-t text-center">
                <td>{{ $i + 1 }}</td>
                <td>{{ $tiket->tipe }}</td>
                <td>Rp {{ number_format($tiket->harga, 0, ',', '.') }}</td>
                <td>{{ $tiket->stok }}</td>
                <td class="flex justify-center gap-2">

                    {{-- Edit --}}
                    <button
                        class="btn btn-sm btn-primary"
                        data-id="{{ $tiket->id }}"
                        data-tipe="{{ e($tiket->tipe) }}"
                        data-harga="{{ $tiket->harga }}"
                        data-stok="{{ $tiket->stok }}"
                        onclick="openFormFromBtn(this)">
                        Edit
                    </button>

                    {{-- Hapus --}}
                    <form action="{{ route('events.tikets.destroy', [$event->id, $tiket->id]) }}"
                        method="POST"
                        class="form-hapus">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-3 py-1 text-sm font-semibold text-white bg-red-600 rounded hover:bg-red-700">
                            Hapus
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- MODAL --}}
    <div id="modalForm" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
            <h2 id="formTitle" class="text-lg font-bold mb-3">Tambah Tiket</h2>

            <form id="tiketForm" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="text-sm font-medium">Tipe</label>
                    <input type="text" name="tipe" id="tipeInput" class="input input-bordered w-full" required>
                </div>

                <div class="mb-3">
                    <label class="text-sm font-medium">Harga</label>
                    <input type="number" name="harga" id="hargaInput" class="input input-bordered w-full" required>
                </div>

                <div class="mb-4">
                    <label class="text-sm font-medium">Stok</label>
                    <input type="number" name="stok" id="stokInput" class="input input-bordered w-full" required>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="submit" class="btn btn-sm btn-primary" id="submitBtn">Simpan</button>
                    <button type="button" onclick="closeForm()" class="btn btn-sm btn-secondary">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ================= DELETE CONFIRM =================
    document.querySelectorAll('.form-hapus').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Yakin hapus tiket?',
                text: 'Data tiket tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // ================= SUBMIT FORM CONFIRM =================
    const tiketForm = document.getElementById('tiketForm');

    tiketForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const isEdit = tiketForm.querySelector('input[name="_method"]');

        Swal.fire({
            title: isEdit ? 'Update tiket?' : 'Simpan tiket?',
            text: isEdit ?
                'Perubahan tiket akan disimpan' : 'Data tiket baru akan ditambahkan',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                tiketForm.submit();
            }
        });
    });

    // ================= MODAL FORM =================
    function resetMethod(form) {
        const m = form.querySelector('input[name="_method"]');
        if (m) m.remove();
    }

    function openFormFromBtn(btn) {
        openForm({
            id: btn.dataset.id,
            tipe: btn.dataset.tipe,
            harga: btn.dataset.harga,
            stok: btn.dataset.stok,
        });
    }

    function openForm(data = null) {
        const modal = document.getElementById('modalForm');
        const form = document.getElementById('tiketForm');

        resetMethod(form);

        if (data) {
            document.getElementById('formTitle').innerText = 'Edit Tiket';
            form.action = `/events/{{ $event->id }}/tikets/${data.id}`;

            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';
            form.appendChild(method);

            tipeInput.value = data.tipe;
            hargaInput.value = data.harga;
            stokInput.value = data.stok;
        } else {
            document.getElementById('formTitle').innerText = 'Tambah Tiket';
            form.action = `/events/{{ $event->id }}/tikets`;
            form.reset();
        }

        modal.classList.remove('hidden');
    }

    function closeForm() {
        document.getElementById('modalForm').classList.add('hidden');
    }



    // ===== MODAL FORM =====
    function resetMethod(form) {
        const m = form.querySelector('input[name="_method"]');
        if (m) m.remove();
    }

    function openFormFromBtn(btn) {
        openForm({
            id: btn.dataset.id,
            tipe: btn.dataset.tipe,
            harga: btn.dataset.harga,
            stok: btn.dataset.stok,
        });
    }

    function openForm(data = null) {
        const modal = document.getElementById('modalForm');
        const form = document.getElementById('tiketForm');

        resetMethod(form);

        if (data) {
            document.getElementById('formTitle').innerText = 'Edit Tiket';
            form.action = `/events/{{ $event->id }}/tikets/${data.id}`;

            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';
            form.appendChild(method);

            tipeInput.value = data.tipe;
            hargaInput.value = data.harga;
            stokInput.value = data.stok;
        } else {
            document.getElementById('formTitle').innerText = 'Tambah Tiket';
            form.action = `/events/{{ $event->id }}/tikets`;
            form.reset();
        }

        modal.classList.remove('hidden');
    }

    function closeForm() {
        document.getElementById('modalForm').classList.add('hidden');
    }
</script>
@endsection