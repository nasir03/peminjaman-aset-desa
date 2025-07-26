<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriAssetController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PesanController;
use App\Mail\PengembalianTerlambatMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Peminjaman;

Route::get('/', function () {
    return view('home');
});

// ==================== LOGIN DAN REGISTER (TERBUKA) ====================
// Login dan logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registrasi (umum)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/tes-email-terlambat', [NotifikasiController::class, 'cekPengembalianTerlambat']);
// ==================== HANYA BISA DIAKSES SETELAH LOGIN ====================
Route::middleware(['auth'])->group(function () {
    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // KATEGORI ASET
    Route::resource('kategori', KategoriAssetController::class);

    // DAFTAR ASET
    Route::resource('asset', AssetController::class);

    // PEMINJAMAN
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.form');
    Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    Route::put('/peminjaman/update-status/{id}', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.updateStatus');
    Route::get('/peminjaman/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');

    // NOTIFIKASI
    Route::get('/cek-notifikasi', [PeminjamanController::class, 'cekNotifikasi']);

    Route::get('/cek-pengembalian-terlambat', [NotifikasiController::class, 'cekPengembalianTerlambat']);

    // PENGEMBALIAN
    Route::get('/pengembalian/create', [PengembalianController::class, 'create'])->name('pengembalian.form');
    Route::post('/pengembalian/store', [PengembalianController::class, 'store'])->name('pengembalian.store');
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::delete('/pengembalian/{id}', [PengembalianController::class, 'destroy'])->name('pengembalian.destroy');
    Route::get('/pengembalian/{id}/edit', [PengembalianController::class, 'edit'])->name('pengembalian.edit');
    Route::put('/pengembalian/{id}', [PengembalianController::class, 'update'])->name('pengembalian.update');

    // USER MANAGEMENT (KHUSUS ADMIN)
    Route::resource('users', UserController::class);
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
  Route::post('/users/{id}/block', [UserController::class, 'toggleBlock'])->name('users.block');

    // DENDA
    Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
    Route::get('/denda/{id_pengembalian}/bayar', [DendaController::class, 'form'])->name('denda.form');
    Route::post('/denda/{id_pengembalian}/bayar', [DendaController::class, 'bayar'])->name('denda.bayar');
    Route::delete('/pembayaran_denda/{id}', [DendaController::class, 'destroy'])->name('pembayaran_denda.destroy');

    // LAPORAN PDF
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.cetak');
    Route::get('/laporan/pdf', [LaporanController::class, 'cetakPDF'])->name('laporan.pdf');

    // PROFIL USER LOGIN
    Route::get('/profil', [UserController::class, 'profil'])->name('profil.index');
    Route::post('/profil/update', [UserController::class, 'updateProfil'])->name('profil.update');
    Route::delete('/profil/hapus-foto', [UserController::class, 'hapusFoto'])->name('profil.hapusFoto');
    Route::post('/profil/update-password', [UserController::class, 'updatePassword'])->name('profil.updatePassword');

    // PESAN
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan.index');
    Route::post('/pesan/kirim', [PesanController::class, 'kirim'])->name('pesan.kirim');
    Route::get('/pesan/baru', [PesanController::class, 'fetchPesanBaru'])->name('pesan.fetch');
    Route::post('/pesan/hapus-semua', [PesanController::class, 'hapusSemua'])->name('pesan.hapusSemua');
});
