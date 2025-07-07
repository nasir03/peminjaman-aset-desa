<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');

            // Relasi user & asset
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_asset');
             $table->unsignedBigInteger('jumlah_pinjam');

            // Data peminjaman
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->string('keperluan_peminjaman');

            // Status & catatan
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan_admin')->nullable();

            // Timestamps
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            // Foreign key
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_asset')->references('id_asset')->on('asset')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
