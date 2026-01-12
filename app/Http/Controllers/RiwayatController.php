<?php

namespace App\Http\Controllers;

use App\Models\Order;

use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('event')
            ->oldest()
            ->get();

        return view('user.riwayat.index', compact('orders'));
    }


    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $order->load('detailOrders.tiket', 'event');

        return view('user.riwayat.show', compact('order'));
    }
}
