<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Notifikasi;
use App\Models\Peminjaman;
use App\Mail\PengingatEmail;
use App\Mail\TelatEmail;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPeminjamanNotifications extends Command
{
    protected $signature = 'send:peminjaman-notifications';
    protected $description = 'Kirim email & notifikasi untuk pengingat H-1 dan keterlambatan H+1';

    public function handle()
    {
        $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();

        // =====================
        // 🔔 Pengingat H-1
        // =====================
        $reminders = Peminjaman::with(['user', 'asset'])
            ->whereDate('tanggal_kembali', $tomorrow)
            ->where('status', 'disetujui') // hanya yang aktif
            ->get();

        foreach ($reminders as $peminjaman) {
            // kirim email pengingat
            Mail::to($peminjaman->user->email)
                ->send(new PengingatEmail($peminjaman));

            // buat notifikasi DB
            Notifikasi::create([
                'id_user'       => $peminjaman->id_user,
                'penerima_id'   => $peminjaman->id_user,
                'id_peminjaman' => $peminjaman->id_peminjaman, 
                'tipe'          => 'pengingat',
                'pesan'         => 'Pengingat: Harap kembalikan aset "'
                    . $peminjaman->asset->nama_asset
                    . '" besok.',
                'dibaca'        => 0,
            ]);

            $this->info('📧 Pengingat H-1 dikirim ke: ' . $peminjaman->user->email);
        }

        // =====================
        // 🚨 Keterlambatan H+1
        // =====================
        $latePeminjamans = Peminjaman::with(['user', 'asset'])
            ->whereDate('tanggal_kembali', '<', $today)
            ->whereNotIn('status', ['selesai', 'dikembalikan', 'ditolak']) // exclude jika sudah kembali / ditolak
            ->get();

        foreach ($latePeminjamans as $peminjaman) {
            // kirim email keterlambatan
            Mail::to($peminjaman->user->email)
                ->send(new TelatEmail($peminjaman));

            // buat notifikasi DB
            Notifikasi::create([
                'id_user'       => $peminjaman->id_user,
                'penerima_id'   => $peminjaman->id_user,
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'tipe'          => 'pengingat',
                'pesan'         => 'Peringatan: Anda terlambat mengembalikan aset "'
                    . $peminjaman->asset->nama_asset
                    . '" segera kembalikan.',
                'dibaca'        => 0,
            ]);

            $this->info('⚠️ Notifikasi keterlambatan dikirim ke: ' . $peminjaman->user->email);
        }

        $this->info("🎉 Semua proses notifikasi selesai.");

        return 0;
    }
}
