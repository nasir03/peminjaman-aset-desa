<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'asset';
    protected $primaryKey = 'id_asset';
    public $timestamps = false;

    protected $fillable = [
        'nama_asset',
        'merek_tipe',
        'harga_aset',
        'jumlah',
        'kondisi',
        'lokasi_asset',
        'photo',
        'deskripsi',
        'id_kategori',
        // Tambahkan kolom 'status' jika nanti kamu pakai
        // 'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriAsset::class, 'id_kategori');
    }

    // ✅ Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_asset', 'id_asset');
    }
}
