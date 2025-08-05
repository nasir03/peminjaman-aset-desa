@extends('back-end.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Judul Halaman -->
    <h1 class="h3 mb-4 text-gray-800">Form Peminjaman Aset Desa</h1>

    <!-- Card Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-success">
            <h6 class="m-0 font-weight-bold text-white">Ajukan Peminjaman</h6>
        </div>
        <div class="card-body">
            <!-- Notifikasi -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Mulai -->
            <form method="POST" action="{{ route('peminjaman.store') }}">
                @csrf
                <div class="row">
                    <!-- KIRI -->
                    <div class="col-md-6">
                        <!-- Nama Peminjam Otomatis -->
                        <div class="form-group">
                            <label for="nama_user">Nama Peminjam</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                            <input type="hidden" name="id_user" value="{{ Auth::id() }}">
                        </div>

                        <div class="form-group">
                            <label for="no_telepon">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="id_asset">Nama Aset</label>
                            <select name="id_asset" class="form-control" required>
                                <option value="">-- Pilih Aset --</option>
                                @foreach($assets as $asset)
                                    <option value="{{ $asset->id_asset }}">{{ $asset->nama_asset }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jumlah_pinjam">Jumlah yang Dipinjam</label>
                            <input type="number" name="jumlah_pinjam" class="form-control" min="1" required>
                        </div>
                    </div>

                    <!-- KANAN -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_pinjam">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_kembali">Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat Lengkap (RT/RW)</label>
                            <textarea name="alamat" class="form-control" rows="2" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="keperluan_peminjaman">Keperluan Peminjaman</label>
                            <textarea name="keperluan_peminjaman" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="catatan_admin">Catatan (untuk admin)</label>
                            <textarea name="catatan_admin" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button id="btnSubmit" type="submit" class="btn btn-success">
                    <span id="btnText">Ajukan Peminjaman</span>
                    <span id="btnLoading" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Suara -->
<audio id="notifSound" src="{{ asset('audio/notif.mp3') }}"></audio>

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const audio = document.getElementById('notifSound');
            if (audio) {
                audio.play().catch(() => {});
            }
        });
    </script>
@endif
@endsection
