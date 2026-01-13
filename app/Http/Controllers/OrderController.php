<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $order = Order::create([
                'user_id' => Auth::id(),
                'event_id' => $request->event_id,
                'order_date' => now(),
                'total_harga' => 0
            ]);

            $total = 0;

            foreach ($request->tickets as $tiket_id => $jumlah) {
                if ($jumlah > 0) {
                    $tiket = Tiket::find($tiket_id);
                    $subtotal = $tiket->harga * $jumlah;

                    DetailOrder::create([
                        'order_id' => $order->id,
                        'tiket_id' => $tiket_id,
                        'jumlah' => $jumlah,
                        'subtotal_harga' => $subtotal
                    ]);

                    // kurangi stok tiket
                    $tiket->decrement('stok', $jumlah);

                    $total += $subtotal;
                }
            }

            $order->update(['total_harga' => $total]);
        });

        return redirect()->route('user.riwayat.index')
            ->with('success', 'Pembelian berhasil');
    }
}
