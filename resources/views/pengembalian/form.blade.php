@extends('back-end.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Form Pengembalian Aset Desa</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-success">
            <h6 class="m-0 font-weight-bold text-white">Data Pengembalian</h6>
        </div>
        <div class="card-body">
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Validasi Error -->
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

            <!-- Form -->
            <form method="POST" action="{{ route('pengembalian.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- KIRI -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_peminjaman">Nama Peminjam</label>
                            <select name="id_peminjaman" class="form-control" required>
                                <option value="">-- Pilih Peminjaman --</option>
                                @foreach($peminjamans as $peminjaman)
                                    <option value="{{ $peminjaman->id_peminjaman }}">
                                        {{ $peminjaman->user->name }} - {{ $peminjaman->asset->nama_asset }} ({{ $peminjaman->tanggal_pinjam }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jumlah_kembali">Jumlah yang Dikembalikan</label>
                            <input type="number" name="jumlah_kembali" class="form-control" min="1" required>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                            <input type="date" name="tanggal_pengembalian" class="form-control" required>
                        </div>
                    </div>

                    <!-- KANAN -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kondisi_asset">Kondisi Aset</label>
                            <select name="kondisi_asset" class="form-control" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="baik">Baik</option>
                                <option value="rusak ringan">Rusak Ringan</option>
                                <option value="rusak berat">Rusak Berat</option>
                                <option value="hilang">Hilang</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="catatan_pengembalian">Catatan (Opsional)</label>
                            <textarea name="catatan_pengembalian" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="foto_kondisi">Foto Kondisi Aset (Opsional)</label>
                            <input type="file" name="foto_kondisi" class="form-control-file" accept="image/*">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-3">Simpan Pengembalian</button>
            </form>
        </div>
    </div>
</div>
@endsection
