@extends('layouts.user')

@section('title', 'Detail Riwayat')

@section('content')
<h1 class="text-xl font-bold mb-4">Detail Pembelian</h1>

<p><strong>Event :</strong> {{ $order->event->judul }}</p>
<p><strong>Tanggal :</strong> {{ $order->order_date->format('d-m-Y H:i') }}</p>

<table class="w-full border mt-4 text-center">
    <thead class="bg-gray-100">
        <tr>
            <th class="border p-2">Tipe Tiket</th>
            <th class="border p-2">Harga</th>
            <th class="border p-2">Jumlah</th>
            <th class="border p-2">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->detailOrders as $detail)
        <tr>
            <td class="border p-2">{{ $detail->tiket->tipe }}</td>
            <td class="border p-2">
                Rp {{ number_format($detail->tiket->harga, 0, ',', '.') }}
            </td>
            <td class="border p-2">{{ $detail->jumlah }}</td>
            <td class="border p-2">
                Rp {{ number_format($detail->subtotal_harga, 0, ',', '.') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<p class="mt-4 font-bold">
    Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}
</p>

<a href="{{ route('user.riwayat.index') }}"
    class="inline-block mt-4 text-blue-600 hover:underline">
    ← Kembali
</a>
@endsection