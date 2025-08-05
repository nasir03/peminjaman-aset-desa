<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Peminjaman;
use App\Models\Asset;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->month;

        // Total peminjaman bulan ini (status Disetujui / Dikembalikan - case-insensitive)
        $totalPeminjaman = Peminjaman::whereMonth('tanggal_pinjam', $bulanIni)
            ->whereRaw("LOWER(status) IN ('disetujui', 'dikembalikan')")
            ->count();

        // Aset tersedia
        $asetTersedia = Asset::whereIn('kondisi', ['baik', 'rusak ringan'])->count();

        // Peminjaman aktif = status Disetujui
        $peminjamanAktif = Peminjaman::whereRaw("LOWER(status) = 'disetujui'")->count();

        // Permohonan pending
        $permohonanPending = Peminjaman::whereRaw("LOWER(status) = 'pending'")->count();

        // Grafik bulanan (tanggal_pinjam)
        $laporanBulanan = Peminjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->whereNotNull('tanggal_pinjam')
            ->whereRaw("LOWER(status) IN ('disetujui', 'dikembalikan')")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Label bulan
        $bulanLabels = $laporanBulanan->map(function ($item) {
            return Carbon::create()->month($item->bulan)->translatedFormat('F');
        });

        // Penggunaan aset
        $penggunaanAset = Asset::withCount('peminjaman')->get();
        $maxUsage = $penggunaanAset->max('peminjaman_count');

        // Peminjaman terbaru
        $latestPeminjaman = Peminjaman::with('user', 'asset')->latest()->take(5)->get();

        return view('back-end.dashboard', compact(
            'totalPeminjaman',
            'asetTersedia',
            'peminjamanAktif',
            'permohonanPending',
            'laporanBulanan',
            'bulanLabels',
            'penggunaanAset',
            'latestPeminjaman',
            'maxUsage'
        ));
    }
}
