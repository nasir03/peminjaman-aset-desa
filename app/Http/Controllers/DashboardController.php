<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Asset;

use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->month;

        // Total peminjaman bulan ini
        $totalPeminjaman = Peminjaman::whereMonth('created_at', $bulanIni)->count();

        // Aset tersedia
        $asetTersedia = Asset::whereIn('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Hilang'])->count();

        // Peminjaman aktif
        $peminjamanAktif = Peminjaman::where('status', 'Dipinjam')->count();

        // Permohonan pending
        $permohonanPending = Peminjaman::where('status', 'Menunggu Persetujuan')->count();

        // Grafik laporan bulanan
        $laporanBulanan = Peminjaman::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Tingkat penggunaan aset
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
            'penggunaanAset',
            'latestPeminjaman',
           
            'maxUsage'
        ));
    }
}
