<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Peminjaman;
use App\Models\Denda;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $primaryKey = 'id_pengembalian';
    public $timestamps = true;

    protected $fillable = [
        'id_peminjaman',
        'tanggal_pengembalian',
        'jumlah_kembali',
        'kondisi_asset',
        'catatan_pengembalian',
        'denda',
        'foto_kondisi',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }

    public function denda()
    {
        return $this->hasOne(Denda::class, 'id_pengembalian');
    }
}
