<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran_denda', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pengembalian');
            $table->integer('jumlah_dibayar');
            $table->string('metode_pembayaran');
            $table->date('tanggal_bayar');
            $table->text('keterangan')->nullable();
            $table->string('foto_pembayaran')->nullable(); // sudah diganti dari bukti_pembayaran
            $table->enum('status', ['pending', 'lunas', 'belum_lunas'])->default('pending');
            $table->timestamps();

            $table->foreign('id_pengembalian')
                  ->references('id_pengembalian')
                  ->on('pengembalian')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_denda');
    }
};
