<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Tiket;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // =====================
        // VALIDASI BACKEND
        // =====================
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'tickets' => 'required|array',
            'payment_id' => 'required|exists:payments,id',
        ]);

        // =====================
        // CEK PAYMENT AKTIF
        // =====================
        $payment = Payment::where('id', $request->payment_id)
            ->where('is_active', true)
            ->firstOrFail();

        DB::transaction(function () use ($request, $payment) {

            $order = Order::create([
                'user_id'     => Auth::id(),
                'event_id'    => $request->event_id,
                'payment_id'  => $payment->id,
                'order_date'  => now(),
                'total_harga' => 0,
            ]);

            $total = 0;
            $adaTiket = false;

            foreach ($request->tickets as $tiket_id => $jumlah) {

                if ($jumlah <= 0) continue;

                $tiket = Tiket::lockForUpdate()->findOrFail($tiket_id);

                // =====================
                // CEK STOK
                // =====================
                if ($tiket->stok < $jumlah) {
                    abort(400, 'Stok tiket tidak mencukupi');
                }

                $subtotal = $tiket->harga * $jumlah;

                DetailOrder::create([
                    'order_id'        => $order->id,
                    'tiket_id'        => $tiket_id,
                    'jumlah'          => $jumlah,
                    'subtotal_harga'  => $subtotal,
                ]);

                $tiket->decrement('stok', $jumlah);

                $total += $subtotal;
                $adaTiket = true;
            }

            // =====================
            // CEGAH ORDER KOSONG
            // =====================
            if (! $adaTiket) {
                abort(400, 'Tidak ada tiket yang dipilih');
            }

            $order->update([
                'total_harga' => $total
            ]);
        });

        return redirect()
            ->route('user.riwayat.index')
            ->with('success', 'Pembelian berhasil, silakan lakukan pembayaran');
    }
}
