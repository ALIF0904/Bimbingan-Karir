<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Kategori::all();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255|unique:kategoris,nama'
        ]);

        Kategori::create(['nama' => $request->nama]);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:255|unique:kategoris,nama,' . $id
        ]);

        $category = Kategori::findOrFail($id);
        $category->update(['nama' => $request->nama]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = Kategori::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}
