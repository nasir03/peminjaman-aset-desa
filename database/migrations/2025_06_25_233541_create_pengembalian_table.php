<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengembalianAsetTable extends Migration
{
    public function up()
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id('id_pengembalian');
            $table->unsignedBigInteger('id_peminjaman');
            $table->unsignedBigInteger('jumlah_kembali');
            $table->date('tanggal_pengembalian');
            $table->enum('kondisi_asset', ['baik', 'rusak ringan', 'rusak berat', 'hilang']);
            $table->text('catatan_pengembalian')->nullable();
            $table->integer('denda')->default(0);

            // ✅ Kolom tambahan untuk menyimpan path foto kondisi aset
            $table->string('foto_kondisi')->nullable();

            $table->timestamps();

            // Foreign key ke tabel peminjaman
            $table->foreign('id_peminjaman')
                ->references('id_peminjaman')
                ->on('peminjaman')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengembalian');
    }
}
