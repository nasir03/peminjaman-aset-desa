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
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriAsset::class, 'id_kategori');
    }
    
}
