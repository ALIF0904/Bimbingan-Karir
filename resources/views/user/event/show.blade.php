@extends('layouts.user')

@section('content')
<h1 class="text-xl font-bold mb-4">{{ $event->judul }}</h1>

<form method="POST" action="{{ route('user.order.store') }}" id="orderForm">
    @csrf
    <input type="hidden" name="event_id" value="{{ $event->id }}">

    <table class="w-full border mb-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2">Tipe Tiket</th>
                <th class="border p-2">Harga</th>
                <th class="border p-2">Jumlah</th>
                <th class="border p-2">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($event->tickets as $tiket)
            <tr class="text-center">
                <td class="border p-2">{{ $tiket->tipe }}</td>
                <td class="border p-2">
                    Rp {{ number_format($tiket->harga) }}
                </td>
                <td class="border p-2">
                    <input type="number"
                           name="tickets[{{ $tiket->id }}]"
                           min="0"
                           value="0"
                           class="border p-1 w-20 jumlah"
                           data-harga="{{ $tiket->harga }}">
                </td>
                <td class="border p-2 subtotal">Rp 0</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-right font-bold mb-4">
        Total: <span id="total">Rp 0</span>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        Beli Tiket
    </button>
</form>

{{-- JS --}}
<script>
    const jumlahInputs = document.querySelectorAll('.jumlah');
    const totalEl = document.getElementById('total');
    const form = document.getElementById('orderForm');

    function hitungTotal() {
        let total = 0;

        jumlahInputs.forEach(input => {
            const harga = parseInt(input.dataset.harga);
            const jumlah = parseInt(input.value) || 0;
            const subtotal = harga * jumlah;

            input.closest('tr').querySelector('.subtotal').innerText =
                'Rp ' + subtotal.toLocaleString('id-ID');

            total += subtotal;
        });

        totalEl.innerText = 'Rp ' + total.toLocaleString('id-ID');
        return total;
    }

    jumlahInputs.forEach(input => {
        input.addEventListener('input', hitungTotal);
    });

    // ==========================
    // VALIDASI + KONFIRMASI SUBMIT
    // ==========================
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const total = hitungTotal();

        // ❌ Belum pilih tiket
        if (total === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tiket belum dipilih',
                text: 'Silakan pilih minimal 1 tiket sebelum melanjutkan',
                confirmButtonText: 'OK'
            });
            return;
        }

        // ✅ Konfirmasi pembelian
        Swal.fire({
            title: 'Konfirmasi Pembelian',
            html: `<b>Total Bayar:</b> Rp ${total.toLocaleString('id-ID')}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Beli',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endsection
