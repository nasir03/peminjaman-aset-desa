<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'id_user',
        'penerima_id',
        'id_peminjaman',
        'tipe', // ✅ WAJIB ditambahkan
        'pesan',
        'dibaca',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
}
