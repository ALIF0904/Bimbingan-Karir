<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Kategori::all();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|max:255|unique:kategoris,nama'
            ]);

            Kategori::create(['nama' => $request->nama]);

            return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan kategori');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|max:255|unique:kategoris,nama,' . $id
            ]);

            Kategori::findOrFail($id)->update([
                'nama' => $request->nama
            ]);

            return redirect()->back()->with('success', 'Kategori berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui kategori');
        }
    }

    public function destroy($id)
    {
        try {
            Kategori::findOrFail($id)->delete();

            // reset AUTO_INCREMENT JIKA TABEL KOSONG
            if (Kategori::count() == 0) {
                DB::statement('ALTER TABLE kategoris AUTO_INCREMENT = 1');
            }

            return redirect()->back()->with('success', 'Kategori berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus kategori');
        }
    }
}
