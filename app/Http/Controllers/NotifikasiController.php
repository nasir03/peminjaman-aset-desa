<?php
namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Notifikasi;
use Carbon\Carbon;
// use Mail; // kalau mau aktifkan email, tinggal uncomment
// use App\Mail\NotifikasiPengingat; // contoh mail class
// use App\Mail\NotifikasiTerlambat; // contoh mail class

class NotifikasiController extends Controller
{
    public function pengingatDanTerlambatPengembalian()
    {
        $hariIni = Carbon::now()->toDateString();
        $besok = Carbon::now()->addDay()->toDateString();

        // ====================
        // 🔹 PENGINGAT H-1
        // ====================
        $peminjamanBesok = Peminjaman::where('status', 'disetujui')
            ->whereDate('tanggal_kembali', $besok)
            ->with('user', 'asset')
            ->get();

        foreach ($peminjamanBesok as $peminjaman) {
            $sudahAda = Notifikasi::where('penerima_id', $peminjaman->id_user)
                ->where('id_peminjaman', $peminjaman->id_peminjaman)
                ->where('tipe', 'pengingat')
                ->whereDate('created_at', $hariIni)
                ->exists();

            if (!$sudahAda) {
                $namaAset = $peminjaman->asset->nama_asset ?? 'aset';
                $tanggalKembali = Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y');

                $pesanUser = "Pengingat: Besok ($tanggalKembali) Anda harus mengembalikan aset {$namaAset}. Harap segera disiapkan.";
                $pesanAdmin = "{$peminjaman->user->name} akan mengembalikan aset {$namaAset} besok ($tanggalKembali).";

                self::simpanNotifikasiDuaArah(
                    $peminjaman->id_peminjaman,
                    'pengingat',
                    $pesanAdmin,
                    $pesanUser,
                    $peminjaman->id_user
                );

                // Kirim Email (opsional)
                /*
                Mail::to($peminjaman->user->email)
                    ->send(new NotifikasiPengingat($pesanUser));
                */
            }
        }

        // ====================
        // 🔹 KETERLAMBATAN
        // ====================
        $terlambat = Peminjaman::where('status', 'disetujui')
            ->whereDate('tanggal_kembali', '<', $hariIni)
            ->with('user', 'asset')
            ->get();

        foreach ($terlambat as $peminjaman) {
            $sudahAda = Notifikasi::where('penerima_id', $peminjaman->id_user)
                ->where('id_peminjaman', $peminjaman->id_peminjaman)
                ->where('tipe', 'pengembalian')
                ->whereDate('created_at', $hariIni)
                ->exists();

            if (!$sudahAda) {
                $namaAset = $peminjaman->asset->nama_asset ?? 'aset';
                $tanggalKembali = Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y');

                $pesanUser = "Peringatan: Anda TELAT mengembalikan aset {$namaAset} yang seharusnya dikembalikan pada {$tanggalKembali}. Segera kembalikan dan bayar denda keterlambatan.";
                $pesanAdmin = "{$peminjaman->user->name} TELAT mengembalikan aset {$namaAset} (seharusnya dikembalikan {$tanggalKembali}).";

                self::simpanNotifikasiDuaArah(
                    $peminjaman->id_peminjaman,
                    'pengembalian',
                    $pesanAdmin,
                    $pesanUser,
                    $peminjaman->id_user
                );

                // Kirim Email (opsional)
                /*
                Mail::to($peminjaman->user->email)
                    ->send(new NotifikasiTerlambat($pesanUser));
                */
            }
        }

        return redirect()->back()->with('success', 'Notifikasi pengingat dan keterlambatan berhasil dikirim.');
    }

    private static function simpanNotifikasiDuaArah($idPeminjaman, $tipe, $pesanAdmin, $pesanUser, $idUser)
    {
        // Notifikasi untuk Admin
        Notifikasi::create([
            'penerima_id' => 1, // ID admin (ubah sesuai sistem kamu)
            'id_peminjaman' => $idPeminjaman,
            'tipe' => $tipe,
            'pesan' => $pesanAdmin
        ]);

        // Notifikasi untuk User
        Notifikasi::create([
            'penerima_id' => $idUser,
            'id_peminjaman' => $idPeminjaman,
            'tipe' => $tipe,
            'pesan' => $pesanUser
        ]);
    }
}
