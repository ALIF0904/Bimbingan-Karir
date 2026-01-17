<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function home(Request $request)
    {
        $kategoriId = $request->query('kategori');
        $categories = Kategori::all();

        $events = Event::with('kategori')
            ->when($kategoriId, fn($q) => $q->where('kategori_id', $kategoriId))
            ->get();

        return view('home', compact('events', 'categories'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function index()
    {
        return view('events.index', [
            'events' => Event::with('kategori')->get(),
            'categories' => Kategori::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'tanggal_waktu' => 'required|date',
            'lokasi' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'required|image|max:2048'
        ]);

        $data['gambar'] = $request->file('gambar')
            ->store('konser', 'public');

        // 🔥 WAJIB TAMBAHKAN INI
        $data['user_id'] = auth()->id();
        Event::create($data);

        return back()->with('success', 'Event ditambahkan');
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'tanggal_waktu' => 'required|date',
            'lokasi' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            if ($event->gambar && Storage::disk('public')->exists($event->gambar)) {
                Storage::disk('public')->delete($event->gambar);
            }

            $data['gambar'] = $request->file('gambar')
                ->store('konser', 'public');
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
