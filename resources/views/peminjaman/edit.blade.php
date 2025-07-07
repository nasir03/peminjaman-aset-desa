@extends('back-end.layouts.app')

@section('content')
<div class="container">
    <h2>Edit Data Peminjaman</h2>

    <form action="{{ route('peminjaman.update', $data->id_peminjaman) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Peminjam</label>
                    <select name="id_user" class="form-control" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $data->id_user == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Aset</label>
                    <select name="id_asset" class="form-control" required>
                        @foreach($assets as $asset)
                            <option value="{{ $asset->id_asset }}" {{ $data->id_asset == $asset->id_asset ? 'selected' : '' }}>
                                {{ $asset->nama_asset }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Jumlah Pinjam</label>
                    <input type="number" name="jumlah_pinjam" class="form-control" value="{{ old('jumlah_pinjam', $data->jumlah_pinjam) }}" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam', $data->tanggal_pinjam) }}" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" class="form-control" value="{{ old('tanggal_kembali', $data->tanggal_kembali) }}" required>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Keperluan</label>
                    <textarea name="keperluan_peminjaman" class="form-control" required>{{ old('keperluan_peminjaman', $data->keperluan_peminjaman) }}</textarea>
                </div>

                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $data->no_telepon ?? $data->user->no_telepon ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="laki-laki" {{ ($data->jenis_kelamin ?? $data->user->jenis_kelamin ?? '') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="perempuan" {{ ($data->jenis_kelamin ?? $data->user->jenis_kelamin ?? '') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" required>{{ old('alamat', $data->alamat ?? $data->user->alamat ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Tombol -->
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
