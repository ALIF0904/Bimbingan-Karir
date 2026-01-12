<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use App\Models\Order;

class DashboardAdminController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalEvent' => Event::count(),
            'totalKategori' => Kategori::count(),
            'totalTransaksi' => Order::count(),
        ]);
    }
}
