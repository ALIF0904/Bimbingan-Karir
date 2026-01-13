<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('event')
            ->oldest()
            ->get();

        return view('user.riwayat.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        $order->load('detailOrders.tiket', 'event');

        return view('user.riwayat.show', compact('order'));
    }
}
