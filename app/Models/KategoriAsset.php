<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriAsset extends Model
{
    use HasFactory;

    protected $table = 'kategori_asset';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function aset()
    {
        return $this->hasMany(Asset::class, 'id_kategori');
    }
}
