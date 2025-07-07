<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_user');       // Pengirim notifikasi
            $table->unsignedBigInteger('penerima_id');   // Penerima notifikasi
            $table->unsignedBigInteger('id_peminjaman'); // ID Peminjaman terkait

            // ✅ TAMBAHAN: tipe notifikasi (WAJIB ADA)
            $table->enum('tipe', ['peminjaman', 'pengembalian', 'denda'])->default('peminjaman');

            $table->string('pesan');
            $table->boolean('dibaca')->default(false);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('penerima_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_peminjaman')->references('id')->on('peminjaman')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
