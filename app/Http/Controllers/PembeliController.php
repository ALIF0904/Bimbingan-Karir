<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PembeliController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('kategori');

        if ($request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }

        $events = $query->latest()->get();
        $kategoris = Kategori::all();

        return view('user.event.index', compact('events', 'kategoris'));
    }

    public function show(Event $event)
    {
        $event->load('tickets');
        return view('user.event.show', compact('event'));
    }
}
