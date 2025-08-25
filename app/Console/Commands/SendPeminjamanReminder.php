<?php
/*
namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Notifikasi;
use App\Models\Peminjaman;
use App\Mail\PengingatEmail;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPeminjamanReminder extends Command
{
    protected $signature = 'send:peminjaman-reminder';
    protected $description = 'Send email reminder to peminjam 1 day before return date';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $peminjamans = Peminjaman::with(['user', 'asset'])
            ->whereDate('tanggal_kembali', $tomorrow)
            ->where('status', 'disetujui')
            ->get();

        foreach ($peminjamans as $peminjaman) {
            // ✅ kirim email
            Mail::to($peminjaman->user->email)
                ->send(new PengingatEmail($peminjaman));

            Notifikasi::create([
                'id_user'       => $peminjaman->id_user,
                'penerima_id'   => $peminjaman->id_user,
                'id_peminjaman' => $peminjaman->id_peminjaman, // kalau PK di table peminjaman = id
                'tipe'          => 'pengingat',
                'pesan'         => 'Pengingat: Harap kembalikan aset "'
                    . $peminjaman->asset->nama_asset
                    . '" besok.',
                'dibaca'        => 0,
            ]);


            $this->info('📧 Reminder email & notifikasi dibuat untuk ' . $peminjaman->user->email);
        }

        return 0;
    }
}
*/