<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use App\Models\Payment;
use Illuminate\Http\Request;

class PembeliController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('kategori');

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        return view('user.event.index', [
            'events'    => $query->latest()->get(),
            'kategoris' => Kategori::all(),
        ]);
    }

    public function show(Event $event)
    {
        // WAJIB: eager load relasi yang dipakai di view
        $event->load(['tickets.typeTiket']);

        // WAJIB: karena view user.event.show menggunakan $payments
        $payments = Payment::where('is_active', true)
            ->orderBy('nama')
            ->get();

        return view('user.event.show', [
            'event'    => $event,
            'payments' => $payments,
        ]);
    }
}
