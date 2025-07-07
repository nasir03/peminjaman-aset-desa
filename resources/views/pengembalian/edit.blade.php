@extends('back-end.layouts.app')

@section('content')
<div class="container">
    <h2>Edit Data Pengembalian Aset</h2>

    <form action="{{ route('pengembalian.update', $pengembalian->id_pengembalian) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Peminjam</label>
                    <input type="text" class="form-control" value="{{ $pengembalian->peminjaman?->user?->name ?? '-' }}" disabled>
                </div>

                <div class="form-group">
                    <label>Nama Aset</label>
                    <input type="text" class="form-control" value="{{ $pengembalian->peminjaman?->asset?->nama_asset ?? '-' }}" disabled>
                </div>

                <div class="form-group">
                    <label>Jumlah Kembali</label>
                    <input type="number" name="jumlah_kembali" class="form-control" value="{{ old('jumlah_kembali', $pengembalian->jumlah_kembali) }}" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Pengembalian</label>
                    <input type="date" name="tanggal_pengembalian" class="form-control" value="{{ old('tanggal_pengembalian', $pengembalian->tanggal_pengembalian) }}" required>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kondisi Aset</label>
                    <select name="kondisi_asset" class="form-control" required>
                        <option value="baik" {{ $pengembalian->kondisi_asset == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak" {{ $pengembalian->kondisi_asset == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="hilang" {{ $pengembalian->kondisi_asset == 'hilang' ? 'selected' : '' }}>Hilang</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Catatan Pengembalian</label>
                    <textarea name="catatan_pengembalian" class="form-control">{{ old('catatan_pengembalian', $pengembalian->catatan_pengembalian) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Denda (Rp)</label>
                    <input type="number" name="denda" class="form-control" value="{{ old('denda', $pengembalian->denda) }}" required>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
