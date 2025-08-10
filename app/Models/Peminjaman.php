<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_asset',
        'jumlah_pinjam',
        'tanggal_pinjam',
        'tanggal_kembali',
        'no_teepon',
        'alamat',
        'jenis_kelamin',
        'status',
        'keperluan_peminjaman',
        'foto_ktp',
        'catatan_admin',
        'created_at',
    ];

    // ✅ Relasi ke user (peminjam)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // ✅ Relasi ke asset
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'id_asset', 'id_asset');
    }

    // ✅ Tambahkan relasi balik ke pengembalian
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'id_peminjaman', 'id_peminjaman');
    }
}