@extends('back-end.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Aset</h1>

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

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('asset.update', $aset->id_asset) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Kiri --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Aset</label>
                            <input type="text" name="nama_asset" class="form-control" value="{{ $aset->nama_asset }}" required>
                        </div>

                        <div class="form-group">
                            <label>Merek/Tipe</label>
                            <input type="text" name="merek_tipe" class="form-control" value="{{ $aset->merek_tipe }}">
                        </div>

                        <div class="form-group">
                            <label>Harga Aset</label>
                            <input type="number" name="harga_aset" class="form-control" value="{{ $aset->harga_aset }}">
                        </div>

                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" value="{{ $aset->jumlah }}">
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="id_kategori" class="form-control" required>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}" {{ $aset->id_kategori == $kat->id_kategori ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Kanan --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" rows="4" class="form-control">{{ $aset->deskripsi }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Kondisi Aset</label>
                            <select name="kondisi" class="form-control">
                                <option value="baik" {{ $aset->kondisi == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak ringan" {{ $aset->kondisi == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="rusak berat" {{ $aset->kondisi == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Lokasi Aset</label>
                            <input type="text" name="lokasi_asset" class="form-control" value="{{ $aset->lokasi_asset }}" required>
                        </div>

                        <div class="form-group">
                            <label>Ganti Foto</label>
                            <input type="file" name="photo" class="form-control-file">
                            @if ($aset->photo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $aset->photo) }}" alt="Foto Aset" style="max-width: 120px; height: auto; border-radius: 6px;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="form-group text-end mt-4">
                    <a href="{{ route('asset.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
