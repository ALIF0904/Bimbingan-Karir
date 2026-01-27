@extends('layouts.admin_layouts')

@section('title', 'Manajemen Payment')

@section('content')
<div class="container mx-auto py-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manajemen Metode Pembayaran</h1>
        <a href="{{ route('payments.create') }}" class="btn btn-primary">
            Tambah Payment
        </a>
    </div>

    <table class="table w-full border">
        <thead class="bg-gray-100 text-center">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tipe</th>
                <th>Nomor / Akun</th>
                <th>Atas Nama</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $i => $payment)
                <tr class="border-t text-center">
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $payment->nama }}</td>
                    <td class="uppercase">{{ $payment->tipe }}</td>
                    <td>{{ $payment->nomor ?? '-' }}</td>
                    <td>{{ $payment->atas_nama ?? '-' }}</td>

                    <td>
                        @if($payment->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-error">Nonaktif</span>
                        @endif
                    </td>

                    <td class="flex justify-center gap-2">
                        <a href="{{ route('payments.edit', $payment->id) }}"
                           class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('payments.toggle', $payment->id) }}"
                              method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="btn btn-sm {{ $payment->is_active ? 'btn-secondary' : 'btn-success' }}">
                                {{ $payment->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>

                        <form id="hapus-{{ $payment->id }}"
                              action="{{ route('payments.destroy', $payment->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                onclick="hapusPayment({{ $payment->id }})"
                                class="btn btn-sm btn-error">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4">
                        Data payment belum tersedia
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function hapusPayment(id) {
    Swal.fire({
        title: 'Yakin hapus?',
        text: 'Metode pembayaran ini akan dihapus',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then(res => {
        if (res.isConfirmed) {
            document.getElementById('hapus-' + id).submit();
        }
    });
}
</script>
@endsection
