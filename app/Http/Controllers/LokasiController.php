<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;


    class LokasiController extends Controller
{
    /**
     * Tampilkan semua lokasi
     */
    public function index()
    {
        $lokasis = Lokasi::orderBy('nama_lokasi')->get();

        return view('lokasis.index', compact('lokasis'));
    }

    /**
     * Simpan lokasi baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lokasi' => 'required|string|max:255|unique:lokasis,nama_lokasi',
        ]);

        Lokasi::create($data);

        return back()->with('success', 'Lokasi berhasil ditambahkan');
    }

    /**
     * Update lokasi
     */
    public function update(Request $request, Lokasi $lokasi)
    {
        $data = $request->validate([
            'nama_lokasi' => 'required|string|max:255|unique:lokasis,nama_lokasi,' . $lokasi->id,
        ]);

        $lokasi->update($data);

        return back()->with('success', 'Lokasi berhasil diperbarui');
    }

    /**
     * Hapus lokasi
     */
    public function destroy(Lokasi $lokasi)
    {
        // Optional: cegah hapus jika masih dipakai event
        if ($lokasi->events()->count() > 0) {
            return back()->with('error', 'Lokasi masih digunakan oleh event');
        }

        $lokasi->delete();

        return back()->with('success', 'Lokasi berhasil dihapus');
    }
};
