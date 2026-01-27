@extends('layouts.user')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6">

    <h1 class="text-2xl font-bold mb-6">{{ $event->judul }}</h1>

    <form method="POST" action="{{ route('user.order.store') }}" id="orderForm">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">

        {{-- TABEL TIKET --}}
        <div class="overflow-x-auto mb-6">
            <table class="w-full border text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border p-2">Tipe Tiket</th>
                        <th class="border p-2">Harga</th>
                        <th class="border p-2">Jumlah</th>
                        <th class="border p-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($event->tickets as $tiket)
                        <tr class="text-center">
                            <td class="border p-2">
                                {{ $tiket->typeTiket?->tipe_tiket ?? '-' }}
                            </td>
                            <td class="border p-2">
                                Rp {{ number_format($tiket->harga) }}
                            </td>
                            <td class="border p-2">
                                <input
                                    type="number"
                                    name="tickets[{{ $tiket->id }}]"
                                    min="0"
                                    value="0"
                                    class="border rounded p-1 w-20 jumlah text-center"
                                    data-harga="{{ $tiket->harga }}">
                            </td>
                            <td class="border p-2 subtotal">Rp 0</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center p-4 text-gray-500">
                                Tiket belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- TOTAL --}}
        <div class="flex justify-end mb-6">
            <div class="text-lg font-semibold">
                Total: <span id="total" class="text-blue-600">Rp 0</span>
            </div>
        </div>

        {{-- METODE PEMBAYARAN --}}
        <div class="mb-6">
            <label class="block font-semibold mb-2">
                Metode Pembayaran
            </label>

            <select
                name="payment_id"
                id="paymentSelect"
                class="w-full border rounded p-2"
                required>
                <option value="">-- Pilih Metode Pembayaran --</option>

                @forelse ($payments as $payment)
                    <option value="{{ $payment->id }}">
                        {{ $payment->nama }} ({{ strtoupper($payment->tipe) }})
                        @if($payment->nomor)
                            - {{ $payment->nomor }}
                        @endif
                        @if($payment->atas_nama)
                            a.n {{ $payment->atas_nama }}
                        @endif
                    </option>
                @empty
                    <option value="" disabled>
                        Metode pembayaran belum tersedia
                    </option>
                @endforelse
            </select>
        </div>

        {{-- SUBMIT --}}
        <div class="flex justify-end">
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold">
                Beli Tiket
            </button>
        </div>
    </form>
</div>

{{-- JS --}}
<script>
    const jumlahInputs = document.querySelectorAll('.jumlah');
    const totalEl = document.getElementById('total');
    const form = document.getElementById('orderForm');
    const paymentSelect = document.getElementById('paymentSelect');

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

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const total = hitungTotal();

        if (total === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tiket belum dipilih',
                text: 'Silakan pilih minimal 1 tiket sebelum melanjutkan'
            });
            return;
        }

        if (!paymentSelect.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Metode pembayaran belum dipilih',
                text: 'Silakan pilih metode pembayaran terlebih dahulu'
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Pembelian',
            html: `<b>Total Bayar:</b> Rp ${total.toLocaleString('id-ID')}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Beli',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endsection
