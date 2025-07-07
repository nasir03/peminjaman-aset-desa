<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\KategoriAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    public function index()
    {
        $aset = Asset::with('kategori')->get();
        return view('asset.index', compact('aset'));
    }

    public function create()
    {
        $kategori = KategoriAsset::all();
        return view('asset.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_asset' => 'required|string|max:100',
            'merek_tipe' => 'nullable|string',
            'harga_aset' => 'nullable|numeric',
            'jumlah' => 'required|integer',
            'kondisi' => 'nullable|in:baik,rusak ringan,rusak berat',
            'lokasi_asset' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string',
            'id_kategori' => 'required|exists:kategori_asset,id_kategori',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('aset', 'public');
        }

        Asset::create($data);

        return redirect()->route('asset.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $aset = Asset::findOrFail($id);
        $kategori = KategoriAsset::all();
        return view('asset.edit', compact('aset', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_asset' => 'required|string|max:100',
            'merek_tipe' => 'nullable|string',
            'harga_aset' => 'nullable|numeric',
            'jumlah' => 'required|integer',
             'kondisi' => 'nullable|in:baik,rusak ringan,rusak berat',
             'lokasi_asset' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string',
            'id_kategori' => 'required|exists:kategori_asset,id_kategori',
        ]);

        $aset = Asset::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('photo')) {
            if ($aset->photo && Storage::disk('public')->exists($aset->photo)) {
                Storage::disk('public')->delete($aset->photo);
            }
            $data['photo'] = $request->file('photo')->store('aset', 'public');
        }

        $aset->update($data);

        return redirect()->route('asset.index')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $aset = Asset::findOrFail($id);
        if ($aset->photo && Storage::disk('public')->exists($aset->photo)) {
            Storage::disk('public')->delete($aset->photo);
        }
        $aset->delete();
        return redirect()->route('asset.index')->with('success', 'Aset berhasil dihapus.');
    }
}