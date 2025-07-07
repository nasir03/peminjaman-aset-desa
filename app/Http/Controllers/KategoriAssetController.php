<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriAsset;

class KategoriAssetController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        $kategori = KategoriAsset::all();
        return view('kategori.index', compact('kategori'));
    }

    // Form tambah kategori
    public function create()
    {
        return view('kategori.create');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriAsset::create($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Tampilkan detail (opsional)
    public function show($id)
    {
        $kategori = KategoriAsset::findOrFail($id);
        return view('kategori.show', compact('kategori'));
    }

    // Form edit kategori
    public function edit($id)
    {
        $kategori = KategoriAsset::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    // Simpan hasil edit
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = KategoriAsset::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Hapus kategori
    public function destroy($id)
    {
        $kategori = KategoriAsset::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
