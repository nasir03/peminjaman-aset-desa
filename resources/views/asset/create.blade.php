@extends('back-end.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Aset Baru</h1>

    {{-- Notifikasi Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('asset.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- Kiri --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Aset</label>
                            <input type="text" name="nama_asset" class="form-control @error('nama_asset') is-invalid @enderror" value="{{ old('nama_asset') }}" required>
                            @error('nama_asset') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Merek/Tipe</label>
                            <input type="text" name="merek_tipe" class="form-control @error('merek_tipe') is-invalid @enderror" value="{{ old('merek_tipe') }}">
                            @error('merek_tipe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Harga Aset</label>
                            <input type="number" name="harga_aset" class="form-control @error('harga_aset') is-invalid @enderror" value="{{ old('harga_aset') }}">
                            @error('harga_aset') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', 1) }}" required>
                            @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('id_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Kanan --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Kondisi Aset</label>
                            <select name="kondisi" class="form-control">
                                <option value="baik">Baik</option>
                                <option value="rusak ringan">Rusak Ringan</option>
                                <option value="rusak berat">Rusak Berat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Lokasi Aset</label>
                            <input type="text" name="lokasi_asset" class="form-control @error('lokasi_asset') is-invalid @enderror" value="{{ old('lokasi_asset') }}" required>
                            @error('lokasi_asset') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Foto</label>
                            <input type="file" name="photo" class="form-control-file @error('photo') is-invalid @enderror">
                            @error('photo') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="form-group text-end mt-4">
                    <a href="{{ route('asset.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
