<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'pembayaran_denda';

    protected $fillable = [
        'id_pengembalian',
        'jumlah_dibayar',
        'metode_pembayaran',
        'tanggal_bayar',
        'keterangan',
        'foto_pembayaran',
    ];

    public $timestamps = true;

    // ✅ Ini relasi sudah BENAR
    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'id_pengembalian', 'id_pengembalian');
    }
}
