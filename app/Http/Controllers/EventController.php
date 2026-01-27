<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /* =======================
     * FRONTEND / USER
     * ======================= */

    public function home(Request $request)
    {
        $kategoriId = $request->query('kategori');

        $categories = Kategori::all();

        $events = Event::with(['kategori', 'lokasi'])
            ->when($kategoriId, fn($q) => $q->where('kategori_id', $kategoriId))
            ->get();

        return view('home', compact('events', 'categories'));
    }

    public function show(Event $event)
    {
        // 🔴 WAJIB eager load tickets + relasinya
        $event->load(['lokasi', 'tickets.typeTiket']);

        $payments = Payment::where('is_active', true)
            ->orderBy('nama')
            ->get();

        return view('user.event.show', compact('event', 'payments'));
    }

    /* =======================
     * BACKEND / ADMIN
     * ======================= */

    public function index()
    {
        return view('events.index', [
            'events'     => Event::with('kategori')->get(),
            'categories' => Kategori::all(),
            'lokasis'    => Lokasi::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'         => 'required|string',
            'deskripsi'     => 'required|string',
            'tanggal_waktu' => 'required|date',
            'lokasi_id'        => 'required|exists:lokasis,id',
            'kategori_id'   => 'required|exists:kategoris,id',
            'gambar'        => 'required|image|max:2048',
        ]);

        $data['gambar'] = $request->file('gambar')->store('konser', 'public');
        $data['user_id'] = auth()->id();

        Event::create($data);

        return back()->with('success', 'Event ditambahkan');
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'judul'         => 'required|string',
            'deskripsi'     => 'required|string',
            'tanggal_waktu' => 'required|date',
            'lokasi_id'        => 'required|exists:lokasis,id',
            'kategori_id'   => 'required|exists:kategoris,id',
            'gambar'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($event->gambar && Storage::disk('public')->exists($event->gambar)) {
                Storage::disk('public')->delete($event->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('konser', 'public');
        }

        $event->update($data);

        return back()->with('success', 'Event diperbarui');
    }

    public function destroy(Event $event)
    {
        if ($event->gambar && Storage::disk('public')->exists($event->gambar)) {
            Storage::disk('public')->delete($event->gambar);
        }

        $event->delete();

        return back()->with('success', 'Event dihapus');
    }
}
