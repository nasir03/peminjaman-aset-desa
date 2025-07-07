<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denda;
use App\Models\Pengembalian;

class DendaController extends Controller
{
    public function index()
    {
        $denda = Denda::with([
            'pengembalian.peminjaman.user',
            'pengembalian.peminjaman.asset'
        ])->get();

        return view('denda.index', compact('denda'));
    }

    public function form($id_pengembalian)
    {
        $pengembalian = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.asset'
        ])->findOrFail($id_pengembalian);

        return view('denda.form', compact('pengembalian'));
    }

    public function bayar(Request $request, $id_pengembalian)
    {
        $request->validate([
            'jumlah_dibayar'      => 'required|numeric|min:1',
            'metode_pembayaran'   => 'required|string',
            'tanggal_bayar'       => 'required|date',
            'keterangan'          => 'nullable|string',
            'foto_pembayaran'     => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $fileName = null;
        if ($request->hasFile('foto_pembayaran')) {
            $file = $request->file('foto_pembayaran');
            $fileName = 'bukti_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/bukti_denda', $fileName); // Simpan ke storage
        }

        Denda::create([
            'id_pengembalian'   => $id_pengembalian,
            'jumlah_dibayar'    => $request->jumlah_dibayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'tanggal_bayar'     => $request->tanggal_bayar,
            'keterangan'        => $request->keterangan,
            'foto_pembayaran'   => $fileName,
        ]);

        return redirect()->route('denda.index')->with('success', 'Pembayaran denda berhasil disimpan.');
    }
}
