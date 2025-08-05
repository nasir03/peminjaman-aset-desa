<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\PengembalianTerlambatMail;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    // Menampilkan notifikasi yang belum dibaca
    public function index()
    {
        $user = Auth::user();

        $notifikasiPeminjaman = DB::table('notifications')
            ->join('users', 'notifications.id_user', '=', 'users.id')
            ->where('notifications.penerima_id', $user->id)
            ->where('notifications.dibaca', false)
            ->orderByDesc('notifications.created_at')
            ->select('notifications.*', 'users.name as nama_user')
            ->get();

        return view('back-end.notifikasi.index', compact('notifikasiPeminjaman'));
    }

    // Tandai sebagai dibaca
    public function tandaiDibaca($id)
    {
        $notif = Notifikasi::findOrFail($id);
        $notif->dibaca = true;
        $notif->save();

        return redirect()->back();
    }

    // Fungsi menyimpan notifikasi (utama)
    public static function simpanNotifikasi($pesan, $penerima_id, $id_peminjaman = null, $tipe = 'peminjaman')
    {
        Notifikasi::create([
            'id_user' => Auth::id(),
            'penerima_id' => $penerima_id,
            'id_peminjaman' => $id_peminjaman,
            'tipe' => $tipe,
            'pesan' => $pesan,
            'dibaca' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function pengingatDanTerlambatPengembalian()
{
    $hariIni = now()->toDateString();
    $besok = now()->addDay()->toDateString();

    // --- 1. Notifikasi PENGINGAT: 1 hari sebelum jatuh tempo
    $peminjamanDekatJatuhTempo = Peminjaman::where('status', 'dipinjam')
        ->whereDate('tanggal_kembali', $besok)
        ->with('user', 'aset')
        ->get();

    foreach ($peminjamanDekatJatuhTempo as $peminjaman) {
        $sudahAda = Notifikasi::where('penerima_id', $peminjaman->user_id)
            ->where('id_peminjaman', $peminjaman->id)
            ->where('tipe', 'pengingat')
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        if (!$sudahAda) {
            $namaAset = $peminjaman->aset->nama_asset ?? 'aset';
            $tanggalKembali = \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y');

            $pesan = "Pengingat: Aset <strong>{$namaAset}</strong> harus dikembalikan BESOK (pada {$tanggalKembali}). Harap segera disiapkan.";

            Notifikasi::create([
                'id_user' => 1,
                'penerima_id' => $peminjaman->user_id,
                'id_peminjaman' => $peminjaman->id,
                'tipe' => 'pengingat',
                'pesan' => strip_tags($pesan),
                'dibaca' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // --- 2. Notifikasi TERLAMBAT: lewat tanggal kembali
    $terlambat = Peminjaman::where('status', 'dipinjam')
        ->whereDate('tanggal_kembali', '<', $hariIni)
        ->with('user', 'aset')
        ->get();

    foreach ($terlambat as $peminjaman) {
        $sudahAda = Notifikasi::where('penerima_id', $peminjaman->user_id)
            ->where('id_peminjaman', $peminjaman->id)
            ->where('tipe', 'pengembalian')
            ->whereDate('created_at', $hariIni)
            ->exists();

        if (!$sudahAda) {
            $namaAset = $peminjaman->aset->nama_asset ?? 'aset';

            $pesan = "Peringatan: Anda belum mengembalikan aset <strong>{$namaAset}</strong> yang seharusnya dikembalikan pada {$peminjaman->tanggal_kembali}.";

            Notifikasi::create([
                'id_user' => 1,
                'penerima_id' => $peminjaman->user_id,
                'id_peminjaman' => $peminjaman->id,
                'tipe' => 'pengembalian',
                'pesan' => strip_tags($pesan),
                'dibaca' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($peminjaman->user && $peminjaman->user->email) {
                Mail::to($peminjaman->user->email)->send(
                    new PengembalianTerlambatMail($peminjaman, strip_tags($pesan))
                );
            }
        }
    }

    return redirect()->back()->with('success', 'Notifikasi pengingat dan keterlambatan berhasil dikirim.');
}
}