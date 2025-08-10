@extends('back-end.layouts.app')

@section('content')
    <div class="container-fluid">
        <h2 class="page-title">Data Peminjaman Aset Desa</h2>

        <link rel="stylesheet" href="{{ asset('back-end/css/peminjaman/index.css') }}">

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="modern-table table table-bordered">
                        <thead class="custom-thead">
                            <tr>
                                <th>Nama Peminjam</th>
                                <th>Nama Aset</th>
                                <th>Jumlah</th>
                                <th>Telepon</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Keperluan</th>
                                <th>Status</th>

                                @auth
                                    @if(Auth::user()->role === 'admin')
                                        <th>Foto KTP</th>
                                        <th style="width: 140px;">Aksi</th>
                                    @endif
                                @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjaman as $data)
                                <tr>
                                    <td>{{ $data->nama_user }}</td>
                                    <td>{{ $data->nama_asset }}</td>
                                    <td>{{ $data->jumlah_pinjam ?? '-' }}</td>
                                    <td>{{ $data->no_telepon }}</td>
                                    <td>{{ ucfirst($data->jenis_kelamin) }}</td>
                                    <td>{{ $data->alamat_user }}</td>
                                    <td>{{ $data->tanggal_pinjam }}</td>
                                    <td>{{ $data->tanggal_kembali }}</td>
                                    <td>{{ $data->keperluan_peminjaman }}</td>
                                    <td>
                                        <span class="badge badge-{{ $data->status == 'pending' ? 'warning' : ($data->status == 'disetujui' ? 'success' : 'danger') }}">
                                            {{ ucfirst($data->status) }}
                                        </span>
                                    </td>

                                    @auth
                                        @if(Auth::user()->role === 'admin')
                                            <td>
                                                @if($data->foto_ktp)
                                                    <a href="{{ asset('storage/' . $data->foto_ktp) }}" target="_blank">Lihat KTP</a>
                                                @else
                                                    Tidak ada
                                                @endif
                                            </td>
                                            <td class="action-cell text-center">
                                                @if ($data->status === 'pending')
                                                    <form action="{{ route('peminjaman.updateStatus', $data->id_peminjaman) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" name="status" value="disetujui"
                                                            class="btn-icon btn-success" title="Setujui">
                                                            <i class="fa-solid fa-square-check"></i>
                                                        </button>
                                                        <button type="submit" name="status" value="ditolak"
                                                            class="btn-icon btn-danger" title="Tolak">
                                                            <i class="fa-solid fa-rectangle-xmark"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge badge-secondary">Selesai</span>
                                                @endif
                                                <a href="{{ route('peminjaman.edit', $data->id_peminjaman) }}"
                                                    class="btn-icon btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('peminjaman.destroy', $data->id_peminjaman) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
