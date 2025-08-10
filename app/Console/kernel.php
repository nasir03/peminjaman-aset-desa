<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\PengingatEmail;
// use App\Mail\TelatEmail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $today = Carbon::now()->toDateString();
           $besok = now()->toDateString();


            // ===================
            // 🔔 PENGINGAT H-1
            // ===================
            $pengingat = Peminjaman::where('status', 'disetujui')
                ->whereDate('tanggal_kembali', $besok)
                ->with('user', 'asset')
                ->get();

            foreach ($pengingat as $p) {
                if (!$p->user) continue;

                // Cek supaya tidak duplikat (sudah dibuat hari ini untuk peminjaman ini)
                $exists = DB::table('notifications')
                    ->where('id_peminjaman', $p->id_peminjaman)
                    ->where('tipe', 'pengingat')
                    ->whereDate('created_at', $today)
                    ->exists();

                if ($exists) continue;

                $tanggalKembali = Carbon::parse($p->tanggal_kembali)->format('d-m-Y');
                $pesanUser = "Pengingat: Besok ({$tanggalKembali}) Anda harus mengembalikan aset " . ($p->asset->nama_asset ?? 'aset') . ".";
                $pesanAdmin = "{$p->user->name} akan mengembalikan aset " . ($p->asset->nama_asset ?? 'aset') . " besok ({$tanggalKembali}).";

                // Simpan untuk admin
                DB::table('notifications')->insert([
                    'id_user' => $p->id_user,          // sumber / pengirim
                    'penerima_id' => 1,               // admin (ubah kalau perlu)
                    'id_peminjaman' => $p->id_peminjaman,
                    'tipe' => 'pengingat',
                    'pesan' => $pesanAdmin,
                    'dibaca' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Simpan untuk user
                DB::table('notifications')->insert([
                    'id_user' => 1,
                    'penerima_id' => $p->id_user,
                    'id_peminjaman' => $p->id_peminjaman,
                    'tipe' => 'pengingat',
                    'pesan' => $pesanUser,
                    'dibaca' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Email (opsional, dikomentari)
                /*
                if ($p->user->email) {
                    Mail::to($p->user->email)->send(new PengingatEmail($p));
                    Log::info('Email pengingat dikirim ke: ' . $p->user->email);
                }
                */
            }

            // ===================
            // ⚠️ KETERLAMBATAN
            // ===================
            $telat = Peminjaman::where('status', 'disetujui')
                ->whereDate('tanggal_kembali', '<', $today)
                ->whereDoesntHave('pengembalian')
                ->with('user', 'asset')
                ->get();

            foreach ($telat as $t) {
                if (!$t->user) continue;

                // Cegah duplikat notifikasi telat per hari
                $exists = DB::table('notifications')
                    ->where('id_peminjaman', $t->id_peminjaman)
                    ->where('tipe', 'pengembalian')
                    ->whereDate('created_at', $today)
                    ->exists();

                if ($exists) continue;

                $tanggalKembali = Carbon::parse($t->tanggal_kembali)->format('d-m-Y');
                $pesanUser = "Peringatan: Anda TELAT mengembalikan aset " . ($t->asset->nama_asset ?? 'aset') .
                            " (batas: {$tanggalKembali}). Segera kembalikan dan bayar denda keterlambatan.";
                $pesanAdmin = "{$t->user->name} TELAT mengembalikan aset " . ($t->asset->nama_asset ?? 'aset') .
                            " (seharusnya dikembalikan {$tanggalKembali}).";

                DB::table('notifications')->insert([
                    'id_user' => $t->id_user,
                    'penerima_id' => 1,
                    'id_peminjaman' => $t->id_peminjaman,
                    'tipe' => 'pengembalian',
                    'pesan' => $pesanAdmin,
                    'dibaca' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('notifications')->insert([
                    'id_user' => 1,
                    'penerima_id' => $t->id_user,
                    'id_peminjaman' => $t->id_peminjaman,
                    'tipe' => 'pengembalian',
                    'pesan' => $pesanUser,
                    'dibaca' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Email (opsional, dikomentari)
                /*
                if ($t->user->email) {
                    Mail::to($t->user->email)->send(new TelatEmail($t));
                    Log::info('Email keterlambatan dikirim ke: ' . $t->user->email);
                }
                */
            }
        })->everyMinute(); // gunakan everyMinute() untuk TEST; ubah ke dailyAt('08:00') saat produksi
    }
}
