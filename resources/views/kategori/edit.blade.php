@extends('back-end.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Kategori Aset</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama_kategori">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" value="{{ $kategori->nama_kategori }}" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{{ $kategori->deskripsi }}</textarea>
                </div>

                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection
