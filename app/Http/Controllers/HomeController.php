<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Kategori;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman home dengan daftar event dan kategori.
     */
    public function index(Request $request)
    {
        // Ambil semua kategori
        $categories = Kategori::all();

        // Ambil event berdasarkan filter kategori (jika ada)
        $query = Event::query();

        if ($request->has('kategori') && $request->kategori != null) {
            $query->where('category_id', $request->kategori);
        }

        $events = $query->get();

        return view('home', compact('categories', 'events'));
    }
}
