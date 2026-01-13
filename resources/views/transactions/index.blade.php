@extends('layouts.admin_layouts')

@section('title', 'Riwayat Pembelian')

@section('content')
<div class="max-w-full mx-auto py-6 px-8">

    {{-- Judul --}}
    <h1 class="text-2xl font-semibold mb-6">History Pembelian</h1>

    {{-- Card --}}
    <div class="bg-white rounded-xl shadow-sm p-8">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 border-b border-gray-200/60">
                        <th class="py-4 px-6 text-center font-medium">No</th>
                        <th class="py-4 px-6 text-center font-medium">Nama Pembeli</th>
                        <th class="py-4 px-6 text-center font-medium">Event</th>
                        <th class="py-4 px-6 text-center font-medium">Tanggal Pembelian</th>
                        <th class="py-4 px-6 text-center font-medium">Total Harga</th>
                        <th class="py-4 px-6 text-center font-medium">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $i => $order)
                    <tr class="border-b border-gray-200/60 hover:bg-gray-50 transition">
                        <td class="py-5 px-6 text-center font-semibold">
                            {{ $i + 1 }}
                        </td>

                        <td class="py-5 px-6 text-center">
                            {{ $order->user->name ?? 'User tidak ditemukan' }}  
                        </td>

                        <td class="py-5 px-6 text-center">
                            {{ $order->event->judul ?? '-' }}
                        </td>

                        <td class="py-5 px-6 text-center">
                            {{ optional($order->order_date)->format('d M Y') }}
                        </td>

                        <td class="py-5 px-6 text-center font-semibold">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </td>

                        <td class="py-5 px-6 text-center">
                            <a href="{{ route('transactions.show', $order->id) }}"
                               class="inline-flex items-center justify-center
                                      bg-blue-500 hover:bg-blue-600
                                      text-white text-xs
                                      px-5 py-2 rounded-md shadow-sm transition">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-400">
                            Data transaksi belum ada
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
