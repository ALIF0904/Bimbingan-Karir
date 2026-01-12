@extends('layouts.admin_layouts')

@section('title', 'Detail Transaksi')

@section('content')
<h1 class="text-xl font-bold mb-4">Detail Transaksi</h1>

<p><strong>Pembeli :</strong> {{ $order->user->name ?? 'User tidak ditemukan' }}</p>
<p><strong>Event :</strong> {{ $order->event->judul ?? '-' }}</p>
<p><strong>Tanggal :</strong> {{ $order->order_date?->format('d-m-Y H:i') }}</p>

<table class="table w-full border mt-4">
    <thead class="bg-gray-100">
        <tr class="bg-gray-100 text-center">
            <th>Tipe Tiket</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->detailOrders as $detail)
        <tr class="text-center border-t">
            <td>{{ $detail->tiket->tipe }}</td>
            <td>Rp {{ number_format($detail->tiket->harga, 0, ',', '.') }}</td>
            <td>{{ $detail->jumlah }}</td>
            <td>Rp {{ number_format($detail->subtotal_harga, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p class="mt-4 font-bold">
    Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}
</p>

<a href="{{ route('transactions.index') }}" class="btn btn-sm mt-4">
    Kembali
</a>
@endsection
