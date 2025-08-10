<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;
use App\Mail\TelatEmail;
use App\Mail\PengingatEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class KirimNotifikasiEmail extends Command
{
    protected $signature = 'email:kirim-otomatis';
    protected $description = 'Mengirim email pengingat H-1 dan telat jika lewat hari kembali';

    public function handle()
    {
        $hariIni = Carbon::now()->toDateString();

        // Pengingat (H-1)
        $pengingat = Peminjaman::whereDate('tanggal_kembali', Carbon::tomorrow())->get();

        foreach ($pengingat as $p) {
            if ($p->user && $p->user->email) {
                Mail::to($p->user->email)->send(new PengingatEmail($p));
            }
        }

        // Telat
        $terlambat = Peminjaman::where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', $hariIni)
            ->get();

        foreach ($terlambat as $p) {
            if ($p->user && $p->user->email) {
                Mail::to($p->user->email)->send(new TelatEmail($p));
            }
        }

        $this->info('✅ Email pengingat dan telat berhasil dikirim.');
    }
}
