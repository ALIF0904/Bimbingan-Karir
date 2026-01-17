@extends('layouts.admin_layouts')

@section('title', 'Manajemen Event')

@section('content')
<div class="w-full px-6 py-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manajemen Event</h1>
        <button onclick="openForm()" class="btn btn-primary">Tambah Event</button>
    </div>

    <table class="table w-full border border-gray-200 rounded-lg">
        <thead>
            <tr class="bg-gray-100 text-center">
                <th>No</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($events as $i => $event)
            <tr class="border-t text-center">
                <td>{{ $i + 1 }}</td>
                <td class="font-semibold">{{ $event->judul }}</td>
                <td class="text-left">
                    {{ \Illuminate\Support\Str::limit($event->deskripsi, 80) }}
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($event->tanggal_waktu)->format('d M Y H:i') }}
                </td>
                <td>{{ $event->lokasi }}</td>
                <td>{{ $event->kategori->nama ?? '-' }}</td>
                <td>
                    <img src="{{ asset('storage/'.$event->gambar) }}"
                        class="w-16 h-16 object-cover rounded mx-auto">
                </td>
                <td>
                    <div class="flex justify-center gap-2">

                        {{-- EDIT --}}
                        <button
                            class="btn btn-sm btn-primary btn-edit"
                            data-id="{{ $event->id }}"
                            data-judul="{{ e($event->judul) }}"
                            data-deskripsi="{{ e($event->deskripsi) }}"
                            data-tanggal="{{ $event->tanggal_waktu }}"
                            data-lokasi="{{ e($event->lokasi) }}"
                            data-kategori="{{ $event->kategori_id }}">
                            Edit
                        </button>

                        {{-- KELOLA TIKET --}}
                        <a href="{{ route('events.tickets.index', $event->id) }}"
                            class="btn btn-sm btn-secondary">
                            Kelola Tiket
                        </a>

                        {{-- DELETE --}}
                        <form method="POST"
                            action="{{ route('events.destroy', $event->id) }}"
                            class="form-delete">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm bg-red-600 text-white">
                                Hapus
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- MODAL --}}
    <div id="modalForm"
        class="fixed inset-0 bg-black/50 hidden z-40 flex items-center justify-center">
        <div class="bg-white p-6 rounded w-full max-w-lg">
            <h2 id="formTitle" class="text-xl font-bold mb-4 text-center">
                Tambah Event
            </h2>

            <form id="eventForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="methodSpoof">

                <div class="mb-3">
                    <label class="font-semibold">Judul Event</label>
                    <input type="text" name="judul" id="judulInput"
                        class="input w-full" required>
                </div>

                <div class="mb-3">
                    <label class="font-semibold">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsiInput"
                        class="textarea w-full" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="font-semibold">Tanggal & Waktu</label>
                    <input type="datetime-local" name="tanggal_waktu"
                        id="tanggalInput" class="input w-full" required>
                </div>

                <div class="mb-3">
                    <label class="font-semibold">Lokasi</label>
                    <input type="text" name="lokasi"
                        id="lokasiInput" class="input w-full" required>
                </div>

                <div class="mb-3">
                    <label class="font-semibold">Kategori</label>
                    <select name="kategori_id"
                        id="kategoriInput" class="input w-full" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="font-semibold">Gambar</label>
                    <input type="file" name="gambar" class="input w-full">
                </div>

                <div class="flex justify-end gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <button type="button" onclick="closeForm()" class="btn">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
@push('scripts')
<script>
    const modal = document.getElementById('modalForm');
    const form = document.getElementById('eventForm');
    const formTitle = document.getElementById('formTitle');

    const judulInput = document.getElementById('judulInput');
    const deskripsiInput = document.getElementById('deskripsiInput');
    const tanggalInput = document.getElementById('tanggalInput');
    const lokasiInput = document.getElementById('lokasiInput');
    const kategoriInput = document.getElementById('kategoriInput');

    function openForm() {
        form.action = '/events';
        formTitle.innerText = 'Tambah Event';
        document.getElementById('methodSpoof')?.remove();
        form.reset();
        modal.classList.remove('hidden');
    }

    function closeForm() {
        modal.classList.add('hidden');
    }

    // EDIT
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.onclick = () => {
            form.action = `/events/${btn.dataset.id}`;
            formTitle.innerText = 'Edit Event';

            document.getElementById('methodSpoof')?.remove();
            form.insertAdjacentHTML(
                'beforeend',
                '<input type="hidden" name="_method" value="PUT" id="methodSpoof">'
            );

            judulInput.value = btn.dataset.judul;
            deskripsiInput.value = btn.dataset.deskripsi;
            tanggalInput.value = btn.dataset.tanggal.replace(' ', 'T').slice(0, 16);
            lokasiInput.value = btn.dataset.lokasi;
            kategoriInput.value = btn.dataset.kategori;

            modal.classList.remove('hidden');
        };
    });

    // DELETE CONFIRM
    document.querySelectorAll('.form-delete').forEach(formDelete => {
        formDelete.addEventListener('submit', e => {
            e.preventDefault();

            Swal.fire({
                title: 'Hapus Event?',
                text: 'Data tidak bisa dikembalikan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    formDelete.submit();
                }
            });
        });
    });
</script>
@endpush