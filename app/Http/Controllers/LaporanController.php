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
        $dendaQuery = Denda::with('pengembalian.peminjaman.user', 'pengembalian.peminjaman.asset');

        // Filter bulan/tahun untuk peminjaman
        if ($bulan) {
            $peminjamanQuery->whereMonth('tanggal_pinjam', $bulan);
            $pengembalianQuery->whereMonth('tanggal_pengembalian', $bulan);
        }
        if ($tahun) {
            $peminjamanQuery->whereYear('tanggal_pinjam', $tahun);
            $pengembalianQuery->whereYear('tanggal_pengembalian', $tahun);
        }

        // Filter bulan/tahun untuk denda digabung dalam satu whereHas
        if ($bulan || $tahun) {
            $dendaQuery->whereHas('pengembalian', function ($q) use ($bulan, $tahun) {
                if ($bulan) $q->whereMonth('tanggal_pengembalian', $bulan);
                if ($tahun) $q->whereYear('tanggal_pengembalian', $tahun);
            });
        }

        // Ambil data berdasarkan jenis laporan
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
            $denda = $dendaQuery->get();

            // Status otomatis
            $denda->map(function ($item) {
                $item->status_otomatis = $item->status === 'pending'
                    ? 'Pending'
                    : ($item->status === 'lunas' ? 'Lunas' : 'Belum Lunas');
                return $item;
            });
        } else {
            $peminjaman = $peminjamanQuery->get();
            $pengembalian = $pengembalianQuery->get();
            $denda = $dendaQuery->get();

            $denda->map(function ($item) {
                $item->status_otomatis = $item->status === 'pending'
                    ? 'Pending'
                    : ($item->status === 'lunas' ? 'Lunas' : 'Belum Lunas');
                return $item;
            });
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
        $dendaQuery = Denda::with('pengembalian.peminjaman.user', 'pengembalian.peminjaman.asset');

        // Filter bulan/tahun untuk PDF
        if ($bulan) {
            $peminjamanQuery->whereMonth('tanggal_pinjam', $bulan);
            $pengembalianQuery->whereMonth('tanggal_pengembalian', $bulan);
        }
        if ($tahun) {
            $peminjamanQuery->whereYear('tanggal_pinjam', $tahun);
            $pengembalianQuery->whereYear('tanggal_pengembalian', $tahun);
        }
        if ($bulan || $tahun) {
            $dendaQuery->whereHas('pengembalian', function ($q) use ($bulan, $tahun) {
                if ($bulan) $q->whereMonth('tanggal_pengembalian', $bulan);
                if ($tahun) $q->whereYear('tanggal_pengembalian', $tahun);
            });
        }

        // Ambil data berdasarkan jenis laporan
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
            $denda = $dendaQuery->get();

            // Status otomatis
            $denda->map(function ($item) {
                $item->status_otomatis = $item->status === 'pending'
                    ? 'Pending'
                    : ($item->status === 'lunas' ? 'Lunas' : 'Belum Lunas');
                return $item;
            });
        } else {
            $peminjaman = $peminjamanQuery->get();
            $pengembalian = $pengembalianQuery->get();
            $denda = $dendaQuery->get();

            $denda->map(function ($item) {
                $item->status_otomatis = $item->status === 'pending'
                    ? 'Pending'
                    : ($item->status === 'lunas' ? 'Lunas' : 'Belum Lunas');
                return $item;
            });
        }

        $pdf = PDF::loadView('laporan.cetak-pdf', compact('peminjaman', 'pengembalian', 'denda'));
        return $pdf->stream('laporan-aset-desa.pdf');
    }
}
