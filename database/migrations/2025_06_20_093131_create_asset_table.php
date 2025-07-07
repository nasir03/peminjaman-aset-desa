<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset', function (Blueprint $table) {
            $table->id('id_asset');
            $table->string('nama_asset');
            $table->string('merek_tipe')->nullable();
            $table->integer('harga_aset')->nullable();
            $table->integer('jumlah')->default(1);
            $table->enum('kondisi', ['baik', 'rusak ringan', 'rusak berat'])->nullable();
            $table->string('lokasi_asset')->nullable();
            $table->string('photo')->nullable();
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('id_kategori');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_kategori')
                  ->references('id_kategori')
                  ->on('kategori_asset')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset');
    }
};
