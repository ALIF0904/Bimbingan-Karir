<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Tiket;
use Illuminate\Http\Request;
use App\Models\TypeTiket;

class TicketController extends Controller
{
    // Lihat daftar tiket per event
    public function index(Event $event)
    {
        // 🔥 PERBAIKAN DI SINI (tickets, bukan tikets)
        $tikets = $event->tickets()->latest()->get();
        $types = TypeTiket::all();

        return view('tickets.index', compact('event', 'tikets', 'types'));
    }

    // Tambah tiket
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'type_tiket_id' => 'required|exists:typetiket,id',
            'harga' => 'required|numeric|min:0',
            'stok'  => 'required|integer|min:0',
        ]);

        $validated['event_id'] = $event->id;

        Tiket::create([
            'event_id' => $event->id,
            'type_tiket_id' => $request->type_tiket_id,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        return redirect()->back()->with('success', 'Tiket berhasil ditambahkan.');
    }

    // Update tiket
    public function update(Request $request, Event $event, Tiket $tiket)
    {
        // Pastikan tiket milik event ini
        abort_unless($tiket->event_id === $event->id, 404);

        $validated = $request->validate([
            'type_tiket_id' => 'required|exists:typetiket,id',
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
