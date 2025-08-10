<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Denda;
use App\Models\Pengembalian;
use App\Models\Notifikasi;
use App\Models\User;

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
            $fileName = $request->file('foto_pembayaran')->store('bukti_denda', 'public');
        }

        $denda = Denda::create([
            'id_pengembalian'   => $id_pengembalian,
            'jumlah_dibayar'    => $request->jumlah_dibayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'tanggal_bayar'     => $request->tanggal_bayar,
            'keterangan'        => $request->keterangan,
            'foto_pembayaran'   => $fileName,
        ]);

        $pengembalian = Pengembalian::with(['peminjaman.user', 'peminjaman.asset'])->findOrFail($id_pengembalian);
        $user = $pengembalian->peminjaman->user;
        $aset = $pengembalian->peminjaman->asset;

        // Kirim notifikasi ke semua ADMIN
        $adminList = User::where('role', 'admin')->get();
        foreach ($adminList as $admin) {
            Notifikasi::create([
                'id_user'       => $user->id,
                'penerima_id'   => $admin->id,
                'id_peminjaman' => $pengembalian->id_peminjaman,
                'tipe'          => 'denda',
                'pesan'         => '✅ ' . $user->name . ' telah membayar denda sebesar Rp ' . number_format($request->jumlah_dibayar, 0, ',', '.') . ' untuk aset ' . $aset->nama_asset . '.',
                'dibaca'        => false,
            ]);
        }

        // Kirim notifikasi ke WARGA
        Notifikasi::create([
            'id_user'       => Auth::id(),
            'penerima_id'   => $user->id,
            'id_peminjaman' => $pengembalian->id_peminjaman,
            'tipe'          => 'denda',
            'pesan'         => '📄 Bukti pembayaran denda sebesar Rp ' . number_format($request->jumlah_dibayar, 0, ',', '.') . ' telah kami terima. Terima kasih.',
            'dibaca'        => false,
        ]);

        return redirect()->route('denda.index')->with('success', 'Pembayaran denda berhasil disimpan.');
    }

    public function destroy($id)
    {
        $pembayaran = Denda::findOrFail($id);

        if ($pembayaran->foto_pembayaran && Storage::exists('public/' . $pembayaran->foto_pembayaran)) {
            Storage::delete('public/' . $pembayaran->foto_pembayaran);
        }

        $pembayaran->delete();

        return redirect()->back()->with('success', 'Data pembayaran denda berhasil dihapus.');
    }
}
