@extends('back-end.layouts.app') {{-- Sesuaikan dengan layout kamu --}}

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Kategori Aset</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama_kategori">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" required>
                    @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"></textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
