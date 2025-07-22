@extends('back-end.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="page-title">Daftar Aset</h1>

        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Tombol Tambah Aset (khusus admin) --}}
        @auth
            @if (Auth::user()->role === 'admin')
                <div class="mb-3 text-end">
                    <a href="{{ route('asset.create') }}" class="btn btn-primary">
                        <i class="fas fa-folder-plus"></i> Tambah Aset
                    </a>
                </div>
            @endif
        @endauth

        {{-- Tambahkan stylesheet --}}
        <link rel="stylesheet" href="{{ asset('back-end/css/aset/style.css') }}">

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="modern-table table table-bordered">
                        <thead class="custom-thead">
                            <tr>
                                <th>No</th>
                                <th>Nama Aset</th>
                                <th>Merek/Tipe</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Kondisi</th>
                                <th>Lokasi</th>
                                <th>Foto</th>
                                @auth
                                    @if (Auth::user()->role === 'admin')
                                        <th style="width: 160px;">Aksi</th>
                                    @endif
                                @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($aset as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $item->nama_asset }}</td>
                                    <td>{{ $item->merek_tipe }}</td>
                                    <td>Rp {{ number_format($item->harga_aset, 0, ',', '.') }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($item->kondisi) }}">
                                            {{ $item->kondisi }}
                                        </span>
                                    </td>
                                    <td>{{ $item->lokasi_asset }}</td>
                                    <td class="photo-cell">
                                        @if ($item->photo)
                                            <img src="{{ asset('storage/' . $item->photo) }}" class="asset-photo"
                                                alt="Asset Photo">
                                        @else
                                            <span class="no-photo">Tidak ada foto</span>
                                        @endif
                                    </td>
                                    @auth
                                        @if (Auth::user()->role === 'admin')
                                            <td class="action-cell text-center">
                                                <a href="{{ route('asset.edit', $item->id_asset) }}"
                                                    class="btn-icon btn-edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('asset.destroy', $item->id_asset) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('Hapus aset ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-icon btn-delete" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    @endauth
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="empty-state">
                                        <div class="empty-content">
                                            <i class="fas fa-inbox"></i>
                                            <p>Belum ada data aset.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
