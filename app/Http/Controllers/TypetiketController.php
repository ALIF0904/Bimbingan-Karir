<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeTiket;
use Illuminate\Support\Facades\DB;

class TypetiketController extends Controller
{
    public function index()
    {
        $types = TypeTiket::orderBy('id')->get();
        return view('types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_tiket' => 'required|string|max:255|unique:typetiket,tipe_tiket'
        ]);

        TypeTiket::create([
            'tipe_tiket' => $request->tipe_tiket
        ]);

        return back()->with('success', 'Tipe tiket berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipe_tiket' => 'required|string|max:255|unique:typetiket,tipe_tiket,' . $id
        ]);

        TypeTiket::findOrFail($id)->update([
            'tipe_tiket' => $request->tipe_tiket
        ]);

        return back()->with('success', 'Tipe tiket berhasil diperbarui');
    }

    public function destroy($id)
    {
        TypeTiket::findOrFail($id)->delete();

        if (TypeTiket::count() === 0) {
            DB::statement('ALTER TABLE typetiket AUTO_INCREMENT = 1');
        }

        return back()->with('success', 'Tipe tiket berhasil dihapus');
    }
}
