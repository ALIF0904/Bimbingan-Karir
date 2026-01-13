@extends('layouts.admin_layouts')

@section('title', 'Detail Transaksi')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-semibold">Detail Pemesanan</h1>
        <span class="text-sm text-gray-500">
            Order #{{ $order->id }} · {{ $order->order_date?->format('d M Y H:i') }}
        </span>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-xl shadow-sm p-8">

        {{-- GRID UTAMA --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 items-start">

            {{-- KIRI : EVENT --}}
            <div class="md:col-span-3 flex flex-col gap-3">
                @if($order->event && $order->event->gambar)
                    <img
                        src="{{ asset('storage/konser/' . $order->event->gambar) }}"
                        alt="{{ $order->event->judul }}"
                        class="w-48 h-48 object-cover rounded-md">
                @endif

                <h2 class="text-lg font-semibold">
                    {{ $order->event->judul ?? '-' }}
                </h2>

                <p class="text-sm text-gray-500">
                    {{ $order->event->lokasi ?? 'Lokasi tidak tersedia' }}
                </p>
            </div>

            {{-- KANAN : RINGKASAN + BUTTON --}}
            <div class="md:col-span-2 flex flex-col justify-between h-full">

                {{-- RINGKASAN --}}
                <div class="space-y-6 text-sm">
                    @foreach ($order->detailOrders as $detail)
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold capitalize">
                                {{ $detail->tiket->tipe }}
                            </p>
                            <p class="text-gray-500">
                                Qty: {{ $detail->jumlah }}
                            </p>
                        </div>

                        <p class="font-semibold">
                            Rp {{ number_format($detail->subtotal_harga, 0, ',', '.') }}
                        </p>
                    </div>
                    @endforeach

                    <div class="border-t border-gray-200"></div>

                    <div class="flex justify-between items-center font-bold text-base">
                        <span>Total</span>
                        <span>
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- BUTTON (SEJAJAR EVENT) --}}
                <div class="flex justify-end pt-2">
                    <a href="{{ route('transactions.index') }}"
                       class="bg-indigo-600 hover:bg-indigo-700
                              text-white text-sm
                              px-6 py-3 rounded-lg shadow transition">
                        Kembali ke Riwayat
                    </a>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection
