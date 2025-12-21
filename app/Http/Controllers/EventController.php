<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Menampilkan semua event, bisa filter berdasarkan kategori
    public function index(Request $request)
    {
        $kategoriId = $request->query('kategori');

        $categories = Kategori::all();

        $events = Event::when($kategoriId, function($query) use ($kategoriId) {
            return $query->where('kategori_id', $kategoriId);
        })->get();

        return view('home', compact('events', 'categories'));
    }

    // Menampilkan detail event
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
}
