@extends('layouts.admin_layouts')

@section('title', 'Manajemen Event')@section('content')<div class="container mx-auto py-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manajemen Event</h1>
        <button onclick="openForm()" class="btn btn-primary">Tambah Event</button>
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
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Tanggal & Waktu</th>
                <th>Lokasi</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($events as $index => $event)
            <tr class="border-t border-gray-200 text-center align-top">
                <td class="py-2">{{ $index + 1 }}</td>

                <td class="py-2 font-semibold">{{ $event->judul }}</td>

                <td class="py-2 text-left">
                    {{ \Illuminate\Support\Str::limit($event->deskripsi, 80) }}
                </td>

                <td class="py-2">
                    {{ \Carbon\Carbon::parse($event->tanggal_waktu)->format('d M Y H:i') }}
                </td>

                <td class="py-2">{{ $event->lokasi }}</td>

                <td class="py-2">
                    {{-- Kalau punya relasi kategori: $event->kategori->nama --}}
                    {{ $event->kategori->nama ?? $event->kategori_id }}
                </td>

                <td class="py-2">
                    {{-- Sesuaikan path gambar kamu (public/images atau storage) --}}
                    <div class="flex justify-center">
                        <img src="{{ asset('images/' . $event->gambar) }}" alt="gambar"
                            class="w-16 h-16 object-cover rounded"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <span class="text-xs text-gray-500 hidden">{{ $event->gambar }}</span>
                    </div>
                </td>

                <td class="py-2">
                    <div class="flex justify-center items-center gap-2">
                        <button class="btn btn-sm btn-primary" data-id="{{ $event->id }}"
                            data-judul="{{ e($event->judul) }}" data-deskripsi="{{ e($event->deskripsi) }}"
                            data-tanggal_waktu="{{ $event->tanggal_waktu }}" data-lokasi="{{ e($event->lokasi) }}"
                            data-kategori_id="{{ $event->kategori_id }}" data-gambar="{{ e($event->gambar) }}"
                            onclick="openFormFromBtn(this)">
                            Edit
                        </button>

                        <a href="{{ route('events.tickets.index', $event->id) }}" class="btn btn-sm btn-secondary">
                            Lihat Tiket
                        </a>

                        <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded btn-sm">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Form -->
    <div id="modalForm" class="absolute inset-0 flex items-center justify-center hidden z-50 pointer-events-none">
        <div class="bg-white p-4 rounded shadow-lg w-full max-w-lg pointer-events-auto">
            <h2 id="formTitle" class="text-lg font-bold mb-3">Tambah Event</h2>

            <form id="eventForm" method="POST" action="{{ route('events.store') }}">
                @csrf

                <input type="hidden" id="idInput">

                <div class="mb-3">
                    <label class="text-sm font-medium">Judul</label>
                    <input type="text" name="judul" id="judulInput" class="input input-bordered w-full text-sm"
                        placeholder="Judul Event" required>
                </div>

                <div class="mb-3">
                    <label class="text-sm font-medium">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsiInput" class="textarea textarea-bordered w-full text-sm"
                        rows="3" placeholder="Deskripsi Event" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="text-sm font-medium">Tanggal & Waktu</label>
                    <input type="datetime-local" name="tanggal_waktu" id="tanggalWaktuInput"
                        class="input input-bordered w-full text-sm" required>
                </div>

                <div class="mb-3">
                    <label class="text-sm font-medium">Lokasi</label>
                    <input type="text" name="lokasi" id="lokasiInput" class="input input-bordered w-full text-sm"
                        placeholder="Lokasi" required>
                </div>

                <div class="mb-3">
                    <label class="text-sm font-medium">Kategori ID</label>
                    <input type="number" name="kategori_id" id="kategoriIdInput"
                        class="input input-bordered w-full text-sm" placeholder="Kategori ID" required>
                </div>

                <div class="mb-4">
                    <label class="text-sm font-medium">Nama File Gambar</label>
                    <input type="text" name="gambar" id="gambarInput" class="input input-bordered w-full text-sm"
                        placeholder="contoh: konser_rock.jpg" required>
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
function toDatetimeLocal(value) {
    // dari "2024-08-15 19:00:00" -> "2024-08-15T19:00"
    if (!value) return '';
    return value.replace(' ', 'T').slice(0, 16);
}

function resetMethodSpoof(form) {
    const old = form.querySelector('input[name="_method"]');
    if (old) old.remove();
}

function openFormFromBtn(btn) {
    openForm({
        id: btn.dataset.id,
        judul: btn.dataset.judul,
        deskripsi: btn.dataset.deskripsi,
        tanggal_waktu: btn.dataset.tanggal_waktu,
        lokasi: btn.dataset.lokasi,
        kategori_id: btn.dataset.kategori_id,
        gambar: btn.dataset.gambar,
    });
}

function openForm(data = null) {
    const modal = document.getElementById('modalForm');
    const form = document.getElementById('eventForm');
    const title = document.getElementById('formTitle');
    const submitBtn = document.getElementById('submitBtn');

    const judulInput = document.getElementById('judulInput');
    const deskripsiInput = document.getElementById('deskripsiInput');
    const tanggalWaktuInput = document.getElementById('tanggalWaktuInput');
    const lokasiInput = document.getElementById('lokasiInput');
    const kategoriIdInput = document.getElementById('kategoriIdInput');
    const gambarInput = document.getElementById('gambarInput');

    resetMethodSpoof(form);

    if (data && data.id) {
        // Edit
        title.textContent = 'Edit Event';
        form.action = `/events/${data.id}`;
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
        submitBtn.textContent = 'Update';

        judulInput.value = data.judul ?? '';
        deskripsiInput.value = data.deskripsi ?? '';
        tanggalWaktuInput.value = toDatetimeLocal(data.tanggal_waktu ?? '');
        lokasiInput.value = data.lokasi ?? '';
        kategoriIdInput.value = data.kategori_id ?? '';
        gambarInput.value = data.gambar ?? '';
    } else {
        // Tambah
        title.textContent = 'Tambah Event';
        form.action = `/events`;
        submitBtn.textContent = 'Simpan';

        judulInput.value = '';
        deskripsiInput.value = '';
        tanggalWaktuInput.value = '';
        lokasiInput.value = '';
        kategoriIdInput.value = '';
        gambarInput.value = '';
    }

    modal.classList.remove('hidden');
}

function closeForm() {
    document.getElementById('modalForm').classList.add('hidden');
}
</script>
@endsection