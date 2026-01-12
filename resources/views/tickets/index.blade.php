@extends('layouts.admin_layouts')

@section('title', 'Manajemen Tiket')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Tiket untuk: {{ $event->judul }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('events.index') }}" class="btn btn-sm">Kembali</a>
            <button onclick="openForm()" class="btn btn-sm btn-primary">Tambah Tiket</button>
        </div>
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
                <td>{{ number_format($tiket->harga, 0, ',', '.') }}</td>
                <td>{{ $tiket->stok }}</td>
                <td class="flex justify-center gap-2">
                    <button
                        class="btn btn-sm btn-primary"
                        data-id="{{ $tiket->id }}"
                        data-tipe="{{ e($tiket->tipe) }}"
                        data-harga="{{ $tiket->harga }}"
                        data-stok="{{ $tiket->stok }}"
                        onclick="openFormFromBtn(this)">
                        Edit
                    </button>


                    <form action="{{ route('events.tikets.destroy', [$event->id, $tiket->id]) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin hapus tiket ini?')">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="px-3 py-1 text-sm font-semibold text-white bg-red-600 rounded hover:bg-red-700">
                            Hapus
                        </button>

                    </form>

                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div id="modalForm" class="absolute inset-0 flex items-center justify-center hidden z-50 pointer-events-none">
        <div class="bg-white p-4 rounded shadow-lg w-full max-w-lg pointer-events-auto">
            <h2 id="formTitle" class="text-lg font-bold mb-3">Tambah Tiket</h2>

            <form id="tiketForm" method="POST" action="{{ route('events.tikets.store', $event->id) }}">
                @csrf

                <div class="mb-3">
                    <label class="text-sm font-medium">Tipe</label>
                    <input type="text" name="tipe" id="tipeInput" class="input input-bordered w-full" required>
                </div>

                <div class="mb-3">
                    <label class="text-sm font-medium">Harga</label>
                    <input type="number" name="harga" id="hargaInput" class="input input-bordered w-full" min="0" required>
                </div>

                <div class="mb-4">
                    <label class="text-sm font-medium">Stok</label>
                    <input type="number" name="stok" id="stokInput" class="input input-bordered w-full" min="0" required>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="submit" class="btn btn-sm btn-primary" id="submitBtn">Simpan</button>
                    <button type="button" onclick="closeForm()" class="btn btn-sm btn-secondary">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function resetMethodSpoof(form) {
        const old = form.querySelector('input[name="_method"]');
        if (old) old.remove();
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
        const title = document.getElementById('formTitle');
        const submitBtn = document.getElementById('submitBtn');

        const tipeInput = document.getElementById('tipeInput');
        const hargaInput = document.getElementById('hargaInput');
        const stokInput = document.getElementById('stokInput');

        resetMethodSpoof(form);

        if (data && data.id) {
            title.textContent = 'Edit Tiket';
            form.action = `/events/{{ $event->id }}/tikets/${data.id}`;

            const m = document.createElement('input');
            m.type = 'hidden';
            m.name = '_method';
            m.value = 'PUT';
            form.appendChild(m);

            submitBtn.textContent = 'Update';

            tipeInput.value = data.tipe;
            hargaInput.value = data.harga;
            stokInput.value = data.stok;
        } else {
            title.textContent = 'Tambah Tiket';
            form.action = `/events/{{ $event->id }}/tikets`;
            submitBtn.textContent = 'Simpan';

            tipeInput.value = '';
            hargaInput.value = '';
            stokInput.value = '';
        }

        modal.classList.remove('hidden');
    }

    function closeForm() {
        document.getElementById('modalForm').classList.add('hidden');
    }
</script>

@endsection