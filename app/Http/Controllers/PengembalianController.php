<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function create()
    {
        $peminjamans = Peminjaman::with('user', 'asset')
            ->where('status', 'disetujui')
            ->get();

        return view('pengembalian.form', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman'        => 'required|exists:peminjaman,id_peminjaman',
            'tanggal_pengembalian' => 'required|date',
            'jumlah_kembali'       => 'required|integer|min:1',
            'kondisi_asset'        => 'required|in:baik,rusak ringan,rusak berat,hilang',
            'catatan_pengembalian' => 'nullable|string',
            'foto_kondisi'         => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $existing = Pengembalian::where('id_peminjaman', $request->id_peminjaman)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Pengembalian untuk aset ini sudah dicatat.');
        }

        $peminjaman = Peminjaman::with('user', 'asset')->findOrFail($request->id_peminjaman);
        $user = $peminjaman->user;
        $aset = $peminjaman->asset;

        $denda = 0;
        $tglKembali = Carbon::parse($peminjaman->tanggal_kembali);
        $tglPengembalian = Carbon::parse($request->tanggal_pengembalian);

        if ($tglPengembalian->gt($tglKembali)) {
            $hariTelat = $tglPengembalian->diffInDays($tglKembali);
            $denda += $hariTelat * 5000;
        }

        $selisih = $peminjaman->jumlah_pinjam - $request->jumlah_kembali;
        if ($selisih > 0) {
            if ($request->kondisi_asset == 'hilang') {
                $denda += $selisih * $aset->harga;
            } else {
                $denda += $selisih * 10000;
            }
        }

        if ($request->kondisi_asset == 'rusak ringan') {
            $denda += 10000;
        } elseif ($request->kondisi_asset == 'rusak berat') {
            $denda += 25000;
        } elseif ($request->kondisi_asset == 'hilang' && $selisih <= 0) {
            $denda += $request->jumlah_kembali * $aset->harga;
        }

        $fotoKondisiPath = null;
        if ($request->hasFile('foto_kondisi')) {
            $fotoKondisiPath = $request->file('foto_kondisi')->store('foto_kondisi_aset', 'public');
        }

        Pengembalian::create([
            'id_peminjaman'        => $request->id_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'jumlah_kembali'       => $request->jumlah_kembali,
            'kondisi_asset'        => $request->kondisi_asset,
            'catatan_pengembalian' => $request->catatan_pengembalian,
            'denda'                => $denda,
            'foto_kondisi'         => $fotoKondisiPath,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        $peminjaman->status = 'dikembalikan';
        $peminjaman->save();

        // === Notifikasi untuk Admin ===
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            DB::table('notifications')->insert([
                'id_user'        => $user->id,
                'penerima_id'    => $admin->id,
                'id_peminjaman'  => $peminjaman->id_peminjaman,
                'tipe'           => 'pengembalian',
                'pesan'          => $user->name . ' telah mengembalikan aset ' . $aset->nama_asset . '.',
                'dibaca'         => false,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            if ($denda > 0) {
                DB::table('notifications')->insert([
                    'id_user'        => $user->id,
                    'penerima_id'    => $admin->id,
                    'id_peminjaman'  => $peminjaman->id_peminjaman,
                    'tipe'           => 'denda',
                    'pesan'          => 'Pengembalian aset oleh ' . $user->name . ' dikenakan denda Rp ' . number_format($denda, 0, ',', '.'),
                    'dibaca'         => false,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil disimpan.');
    }

    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman.user', 'peminjaman.asset', 'denda'])->get();
        return view('pengembalian.index', compact('pengembalians'));
    }

    public function denda()
    {
        return $this->hasOne(Denda::class, 'id_pengembalian');
    }

    public function destroy($id)
    {
        Pengembalian::where('id_pengembalian', $id)->delete();
        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil dihapus.');
    }

    public function edit($id)
    {
        $pengembalian = Pengembalian::with(['peminjaman.user', 'peminjaman.asset'])->findOrFail($id);
        return view('pengembalian.edit', compact('pengembalian'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_kembali'       => 'required|integer|min:1',
            'tanggal_pengembalian' => 'required|date',
            'kondisi_asset'        => 'required|string',
            'catatan_pengembalian' => 'nullable|string',
            'denda'                => 'required|numeric|min:0',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->update($request->only([
            'jumlah_kembali',
            'tanggal_pengembalian',
            'kondisi_asset',
            'catatan_pengembalian',
            'denda'
        ]));

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil diperbarui.');
    }
}
