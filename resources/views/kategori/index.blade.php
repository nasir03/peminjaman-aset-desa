@extends('back-end.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kategori Aset</h1>

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Tambahkan stylesheet kategori --}}
    <link rel="stylesheet" href="{{ asset('back-end/css/kategori/style.css') }}">

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="custom-thead">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            @if(Auth::user()->role === 'admin')
                                <th style="width: 160px;">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategori as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_kategori }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                @if(Auth::user()->role === 'admin')
                                <td class="kategori-aksi">
                                    {{-- Tambah Kategori --}}
                                    <a href="{{ route('kategori.create') }}" class="btn-icon btn-tambah" title="Tambah Kategori Baru">
                                        <i class="fas fa-folder-plus"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('kategori.edit', $item->id_kategori) }}" class="btn-icon btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('kategori.destroy', $item->id_kategori) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-hapus" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role === 'admin' ? '4' : '3' }}" class="text-center text-muted">Belum ada data kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
