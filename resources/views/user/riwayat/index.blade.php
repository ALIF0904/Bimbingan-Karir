@extends('layouts.user')

@section('title', 'Riwayat Pembelian')

@section('content')
<h1 class="text-xl font-bold mb-4">Riwayat Pembelian Tiket</h1>

@if($orders->isEmpty())
<p class="text-gray-500">Belum ada transaksi.</p>
@else
<table class="w-full border text-center">
    <thead class="bg-gray-100">
        <tr>
            <th class="border p-2">No</th>
            <th class="border p-2">Event</th>
            <th class="border p-2">Tanggal</th>
            <th class="border p-2">Total</th>
            <th class="border p-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr class="bg-gray-100 text-center"></tr>
        <td class="border p-2">{{ $loop->iteration }}</td>
        <td class="border p-2">{{ $order->event->judul }}</td>
        <td class="border p-2">{{ $order->order_date->format('d-m-Y H:i') }}</td>
        <td class="border p-2">
            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
        </td>
        <td class="border p-2 text-center">
            <a href="{{ route('user.riwayat.show', $order->id) }}"
                class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-1 rounded text-sm">
                Detail
            </a>
        </td>

        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection