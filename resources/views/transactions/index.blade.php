@extends('layouts.admin_layouts')

@section('title', 'Daftar Transaksi')

@section('content')
<h1 class="text-2xl font-bold mb-4">Daftar Transaksi</h1>

<table class="table w-full border">
    <thead class="bg-gray-100">
        <tr class="bg-gray-100 text-center">
            <th>No </th>
            <th>Pembeli</th>
            <th>Event</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $i => $order)
       <tr class="bg-gray-100 text-center">
            <td>{{ $i + 1 }}</td>
            <td>{{ $order->user->name ?? 'User tidak ditemukan' }}</td>
            <td>{{ $order->event->judul ?? '-' }}</td>
            <td>{{ optional($order->order_date)->format('d-m-Y H:i') }}</td>
            <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
            <td>
                <a href="{{ route('transactions.show', $order->id) }}"
                    class="btn btn-sm btn-secondary">
                    Detail
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center text-gray-500">
                Data transaksi belum ada
            </td>
        </tr>
        @endforelse
    </tbody>

</table>
@endsection