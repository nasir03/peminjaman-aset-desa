<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Notifikasi;
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
        $hargaAset = $aset->harga_aset ?? 0;

        $jumlahPinjam = $peminjaman->jumlah_pinjam;
        $jumlahKembali = $request->jumlah_kembali;

        if ($jumlahKembali > $jumlahPinjam) {
            return redirect()->back()->with('error', 'Jumlah kembali tidak boleh melebihi jumlah pinjam.');
        }

        // ===== Perhitungan Denda =====
        $denda = 0;

        // Pastikan hanya membandingkan tanggal tanpa jam
        $tglKembali = Carbon::parse($peminjaman->tanggal_kembali)->startOfDay();
        $tglPengembalian = Carbon::parse($request->tanggal_pengembalian)->startOfDay();

        // Hitung denda keterlambatan (selalu dihitung walaupun kondisi baik)
      if ($tglPengembalian->gt($tglKembali)) {
    $hariTerlambat = $tglKembali->diffInDays($tglPengembalian); 
    $denda += $hariTerlambat * 5000;
}


        // Denda berdasarkan kondisi aset
        switch ($request->kondisi_asset) {
            case 'rusak ringan':
                $denda += $jumlahKembali * $hargaAset * 0.3;
                break;
            case 'rusak berat':
                $denda += $jumlahKembali * $hargaAset * 0.8;
                break;
            case 'hilang':
                $denda += $jumlahKembali * $hargaAset;
                break;
        }

        // Denda kalau jumlah kembali kurang dari pinjam
        if ($jumlahKembali < $jumlahPinjam) {
            $jumlahTidakKembali = $jumlahPinjam - $jumlahKembali;
            $denda += $jumlahTidakKembali * $hargaAset;
        }

        $denda = max(0, round($denda));

        // Upload foto kondisi jika ada
        $fotoKondisiPath = null;
        if ($request->hasFile('foto_kondisi')) {
            $fotoKondisiPath = $request->file('foto_kondisi')->store('foto_kondisi_aset', 'public');
        }

        // Simpan data pengembalian
        Pengembalian::create([
            'id_peminjaman'        => $request->id_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'jumlah_kembali'       => $jumlahKembali,
            'kondisi_asset'        => $request->kondisi_asset,
            'catatan_pengembalian' => $request->catatan_pengembalian,
            'denda'                => $denda,
            'foto_kondisi'         => $fotoKondisiPath,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        // Update status peminjaman
        $peminjaman->status = 'dikembalikan';
        $peminjaman->save();

        // Kirim notifikasi ke admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Notifikasi::create([
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
                // Notifikasi ke admin
                Notifikasi::create([
                    'id_user'        => $user->id,
                    'penerima_id'    => $admin->id,
                    'id_peminjaman'  => $peminjaman->id_peminjaman,
                    'tipe'           => 'denda',
                    'pesan'          => 'Pengembalian aset oleh ' . $user->name . ' dikenakan denda Rp ' . number_format($denda, 0, ',', '.'),
                    'dibaca'         => false,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                // Notifikasi ke user
                Notifikasi::create([
                    'id_user'        => $admin->id,
                    'penerima_id'    => $user->id,
                    'id_peminjaman'  => $peminjaman->id_peminjaman,
                    'tipe'           => 'denda',
                    'pesan'          => 'Anda dikenakan denda sebesar Rp ' . number_format($denda, 0, ',', '.') . ' karena keterlambatan atau kondisi aset tidak baik.',
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
