<?php

namespace App\Http\Controllers;

use App\Models\Order;

class TransactionController extends Controller
{
    // INDEX = Riwayat Pembelian
    public function index()
    {
        $orders = Order::with(['user', 'event'])
            ->orderBy('order_date')
            ->get();

        return view('transactions.index', compact('orders'));
    }

    // SHOW = detail transaksi
    public function show($id)
    {
        $order = Order::with([
            'user',
            'event',
            'detailOrders.tiket'
        ])->findOrFail($id);

        return view('transactions.show', compact('order'));
    }
}
