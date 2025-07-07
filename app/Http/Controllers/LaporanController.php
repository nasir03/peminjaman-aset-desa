<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use PDF;

class LaporanController extends Controller
{
    // Tampilkan laporan default (di halaman web)
    public function index(Request $request)
    {
        $jenis = $request->input('jenis');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Include semua relasi penting
        $peminjamanQuery = Peminjaman::with(['user', 'asset']);
        $pengembalianQuery = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.asset',
            'denda' // ← sudah diganti
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
        } elseif ($jenis === 'pengembalian') {
            $peminjaman = collect();
            $pengembalian = $pengembalianQuery->get();
        } elseif ($jenis === 'denda') {
            $peminjaman = collect();
            $pengembalian = $pengembalianQuery->where('denda', '>', 0)->get();
        } else {
            $peminjaman = $peminjamanQuery->get();
            $pengembalian = $pengembalianQuery->get();
        }

        return view('laporan.cetak', compact('peminjaman', 'pengembalian'));
    }

    // Cetak ke PDF
    public function cetakPDF(Request $request)
    {
        $jenis = $request->input('jenis');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $peminjamanQuery = Peminjaman::with(['user', 'asset']);
        $pengembalianQuery = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.asset',
            'denda' // ← sudah diganti juga di sini
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
        } elseif ($jenis === 'pengembalian') {
            $peminjaman = collect();
            $pengembalian = $pengembalianQuery->get();
        } elseif ($jenis === 'denda') {
            $peminjaman = collect();
            $pengembalian = $pengembalianQuery->where('denda', '>', 0)->get();
        } else {
            $peminjaman = $peminjamanQuery->get();
            $pengembalian = $pengembalianQuery->get();
        }

        $pdf = PDF::loadView('laporan.cetak-pdf', compact('peminjaman', 'pengembalian'));
        return $pdf->stream('laporan-aset-desa.pdf');
    }
}
