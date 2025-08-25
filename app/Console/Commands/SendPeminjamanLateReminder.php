<?php
/*
namespace App\Console\Commands;

use App\Mail\TelatEmail;
use App\Models\Notifikasi;
use Illuminate\Console\Command;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class SendPeminjamanLateReminder extends Command
{
    protected $signature = 'send:peminjaman-late-reminder';
    protected $description = 'Send email reminder to peminjam who are late in returning assets';

    public function handle()
    {
        \Log::info("⏳ Memulai pengecekan peminjaman terlambat...");

        $today = Carbon::today()->toDateString();

        $latePeminjamans = Peminjaman::with(['user', 'asset'])
            ->whereDate('tanggal_kembali', '<', $today)
            ->where('status', '!=', 'selesai') // status selain selesai, artinya belum kembali
            ->get();

        \Log::info("📋 Jumlah peminjaman terlambat ditemukan: " . $latePeminjamans->count());

        foreach ($latePeminjamans as $peminjaman) {
            Mail::to($peminjaman->user->email)
                ->send(new TelatEmail($peminjaman));

            Notifikasi::create([
                'id_user'       => $peminjaman->id_user,
                'penerima_id'   => $peminjaman->id_user,
                'id_peminjaman' => $peminjaman->id_peminjaman, // kalau PK di table peminjaman = id
                'tipe'          => 'pengingat',
                'pesan'         => 'Peringatan: Anda terlambat mengembalikan aset "'
                    . $peminjaman->asset->nama_asset
                    . '" Segera kembalikan.',
                'dibaca'        => 0,
            ]);


            \Log::info('✅ Email keterlambatan dikirim ke: ' . $peminjaman->user->email);
        }

        \Log::info("🎉 Proses pengiriman email keterlambatan selesai.");

        return 0;
    }
}
*/