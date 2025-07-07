<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    // Sesuaikan nama tabel di database
    protected $table = 'pembayaran_denda';

    protected $fillable = [
        'id_pengembalian',
        'jumlah_dibayar',
        'metode_pembayaran',
        'tanggal_bayar',
        'keterangan',
        'bukti_pembayaran',
    ];

    public $timestamps = true; // jika tabel kamu punya kolom created_at & updated_at

    // Relasi ke pengembalian
    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'id_pengembalian');
    }

public function laporan()
{
    $peminjaman = Peminjaman::with('user', 'asset')->get();
    $pengembalian = Pengembalian::with('peminjaman.user', 'peminjaman.asset')->get();
    $denda = Denda::with('pengembalian.peminjaman.user', 'pengembalian.peminjaman.asset')->get();

    return view('laporan.index', compact('peminjaman', 'pengembalian', 'denda'));
}

}
