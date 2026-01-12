<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Tiket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // Lihat daftar tiket per event
    public function index(Event $event)
    {
        // 🔥 PERBAIKAN DI SINI (tickets, bukan tikets)
        $tikets = $event->tickets()->latest()->get();

        return view('tickets.index', compact('event', 'tikets'));
    }

    // Tambah tiket
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'tipe'  => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok'  => 'required|integer|min:0',
        ]);

        $validated['event_id'] = $event->id;

        Tiket::create($validated);

        return redirect()->back()->with('success', 'Tiket berhasil ditambahkan.');
    }

    // Update tiket
    public function update(Request $request, Event $event, Tiket $tiket)
    {
        // Pastikan tiket milik event ini
        abort_unless($tiket->event_id === $event->id, 404);

        $validated = $request->validate([
            'tipe'  => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok'  => 'required|integer|min:0',
        ]);

        $tiket->update($validated);

        return redirect()->back()->with('success', 'Tiket berhasil diperbarui.');
    }

    // Hapus tiket
    public function destroy(Event $event, Tiket $tiket)
    {
        abort_unless($tiket->event_id === $event->id, 404);

        $tiket->delete();

        return redirect()->back()->with('success', 'Tiket berhasil dihapus.');
    }
}
