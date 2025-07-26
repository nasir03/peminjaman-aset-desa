<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Denda;
use PDF;

class LaporanController extends Controller
{
   public function index(Request $request)
{
    $jenis = $request->input('jenis');
    $bulan = $request->input('bulan');
    $tahun = $request->input('tahun');

    $peminjamanQuery = Peminjaman::with(['user', 'asset']);
    $pengembalianQuery = Pengembalian::with([
        'peminjaman.user',
        'peminjaman.asset',
        'denda'
    ]);

    // Filter bulan/tahun terpisah (tidak harus dua-duanya)
    if ($bulan) {
        $peminjamanQuery->whereMonth('tanggal_pinjam', $bulan);
        $pengembalianQuery->whereMonth('tanggal_pengembalian', $bulan);
    }
    if ($tahun) {
        $peminjamanQuery->whereYear('tanggal_pinjam', $tahun);
        $pengembalianQuery->whereYear('tanggal_pengembalian', $tahun);
    }

    if ($jenis === 'peminjaman') {
        $peminjaman = $peminjamanQuery->get();
        $pengembalian = collect();
        $denda = collect();
    } elseif ($jenis === 'pengembalian') {
        $peminjaman = collect();
        $pengembalian = $pengembalianQuery->get();
        $denda = collect();
    } elseif ($jenis === 'denda') {
        $peminjaman = collect();
        $pengembalian = collect();
        $dendaQuery = Denda::with('pengembalian.peminjaman.user', 'pengembalian.peminjaman.asset');

        if ($bulan) {
            $dendaQuery->whereHas('pengembalian', fn($q) => $q->whereMonth('tanggal_pengembalian', $bulan));
        }
        if ($tahun) {
            $dendaQuery->whereHas('pengembalian', fn($q) => $q->whereYear('tanggal_pengembalian', $tahun));
        }

        $denda = $dendaQuery->get();
    } else {
        $peminjaman = $peminjamanQuery->get();
        $pengembalian = $pengembalianQuery->get();
        $denda = Denda::with('pengembalian.peminjaman.user', 'pengembalian.peminjaman.asset')->get();
    }

    return view('laporan.cetak', compact('peminjaman', 'pengembalian', 'denda'));
}


    public function cetakPDF(Request $request)
    {
        $jenis = $request->input('jenis');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $peminjamanQuery = Peminjaman::with(['user', 'asset']);
        $pengembalianQuery = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.asset',
            'denda'
        ]);

        if ($bulan && $tahun) {
            $peminjamanQuery->whereMonth('tanggal_pinjam', $bulan)
                            ->whereYear('tanggal_pinjam', $tahun);

            $pengembalianQuery->whereMonth('tanggal_pengembalian', $bulan)
                              ->whereYear('tanggal_pengembalian', $tahun);
        }

        if ($jenis === 'peminjaman') {
            $peminjaman = $peminjamanQuery->get();
            $pengembalian = collect();
            $denda = collect();
        } elseif ($jenis === 'pengembalian') {
            $peminjaman = collect();
            $pengembalian = $pengembalianQuery->get();
            $denda = collect();
        } elseif ($jenis === 'denda') {
            $peminjaman = collect();
            $pengembalian = collect();
            $denda = Denda::with('pengembalian.peminjaman.user', 'pengembalian.peminjaman.asset');

            if ($bulan && $tahun) {
                $denda->whereHas('pengembalian', function ($query) use ($bulan, $tahun) {
                    $query->whereMonth('tanggal_pengembalian', $bulan)
                          ->whereYear('tanggal_pengembalian', $tahun);
                });
            }

            $denda = $denda->get();
        } else {
            $peminjaman = $peminjamanQuery->get();
            $pengembalian = $pengembalianQuery->get();
            $denda = Denda::with('pengembalian.peminjaman.user', 'pengembalian.peminjaman.asset')->get();
        }

        $pdf = PDF::loadView('laporan.cetak-pdf', compact('peminjaman', 'pengembalian', 'denda'));
        return $pdf->stream('laporan-aset-desa.pdf');
    }
}
