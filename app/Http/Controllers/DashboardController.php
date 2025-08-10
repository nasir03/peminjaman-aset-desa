<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Peminjaman;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->month;

        // Total peminjaman bulan ini (disetujui + dikembalikan)
        $totalPeminjaman = Peminjaman::whereMonth('tanggal_pinjam', $bulanIni)
            ->whereIn('status', ['disetujui', 'dikembalikan'])
            ->count();

        // Jumlah aset tersedia (kondisi baik atau rusak ringan)
        $asetTersedia = Asset::whereIn('kondisi', ['baik', 'rusak ringan'])->count();

        // Total user terdaftar
        $totalUser = User::count();

        // Permohonan pending
        $permohonanPending = Peminjaman::where('status', 'pending')->count();

        // User kena denda, join tabel pembayaran_denda -> pengembalian -> peminjaman ambil distinct user
       $userKenaDenda = DB::table('pengembalian as p')
    ->where('p.denda', '>', 0)
    ->count();



        // Peminjaman ditolak
        $peminjamanDitolak = Peminjaman::where('status', 'ditolak')->count();

        // Peminjaman disetujui
        $peminjamanDisetujui = Peminjaman::where('status', 'disetujui')->count();

        // Aset yang sudah dikembalikan (jumlah peminjaman dengan status dikembalikan)
        $asetSudahDikembalikan = Peminjaman::where('status', 'dikembalikan')->count();

        // Data grafik bulanan peminjaman (status disetujui + dikembalikan)
        $bulanLabels = collect(range(1, 12))->map(function ($bulan) {
            return Carbon::create()->month($bulan)->translatedFormat('F');
        });

        $rawData = Peminjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->whereNotNull('tanggal_pinjam')
            ->whereIn('status', ['disetujui', 'dikembalikan'])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $laporanBulanan = collect(range(1, 12))->map(function ($bulan) use ($rawData) {
            return $rawData[$bulan]->total ?? 0;
        });

        // Statistik penggunaan aset
        $penggunaanAset = Asset::withCount('peminjaman')->get();
        $maxUsage = $penggunaanAset->max('peminjaman_count');

        // Peminjaman terbaru (5 data terakhir)
        $latestPeminjaman = Peminjaman::with('user', 'asset')->latest()->take(5)->get();

        return view('back-end.dashboard', compact(
            'totalPeminjaman',
            'asetTersedia',
            'totalUser',
            'permohonanPending',
            'userKenaDenda',
            'peminjamanDitolak',
            'peminjamanDisetujui',
            'asetSudahDikembalikan',
            'laporanBulanan',
            'bulanLabels',
            'penggunaanAset',
            'latestPeminjaman',
            'maxUsage'
        ));
    }
}
