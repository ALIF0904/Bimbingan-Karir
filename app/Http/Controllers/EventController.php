<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Home: bisa filter berdasarkan kategori
    public function home(Request $request)
    {
        $kategoriId = $request->query('kategori');
        $categories = Kategori::all();

        $events = Event::with('kategori')
            ->when($kategoriId, function ($query) use ($kategoriId) {
                return $query->where('kategori_id', $kategoriId);
            })
            ->get();

        return view('home', compact('events', 'categories'));
    }

    // Detail event
    public function show(Event $event)
    {
        $event->load('kategori');
        return view('events.show', compact('event'));
    }

    // Admin index
    public function index()
    {
        $events = Event::with('kategori')->get();
        return view('events.index', compact('events'));
    }

    // Store event (sesuai seeder)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_waktu' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'required|string|max:255',
        ]);

        $validated['user_id'] = auth()->id() ?? 1;

        Event::create($validated);

        return redirect()->back()->with('success', 'Event berhasil ditambahkan.');
    }


    // (Opsional) Tampilkan halaman form edit
    public function edit(Event $event)
    {
        $event->load('kategori');
        $categories = Kategori::all();

        return view('events.edit', compact('event', 'categories'));
    }

    // Update event
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_waktu' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'required|string|max:255',
        ]);

        $event->update($validated);

        return redirect()->back()->with('success', 'Event berhasil diperbarui.');
    }

    // Hapus event
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->back()->with('success', 'Event berhasil dihapus.');
    }

}