@extends('back-end.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="page-title">Data Pengembalian Aset Desa</h1>

        <link rel="stylesheet" href="{{ asset('back-end/css/pengembalian/index.css') }}">

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
                                <th>No</th>
                                <th>Nama Peminjam</th>
                                <th>Nama Aset</th>
                                <th>Jumlah Kembali</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Kondisi Aset</th>
                                <th>Catatan</th>
                                <th>Foto Kondisi</th> {{-- ✅ Kolom baru --}}
                                <th><strong>Denda</strong></th>
                                @auth
                                    @if (in_array(Auth::user()->role, ['admin', 'warga']))
                                        <th style="width: 100px;">Aksi</th>
                                    @endif
                                @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengembalians as $pengembalian)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pengembalian->peminjaman?->user?->name ?? 'Tidak Ditemukan' }}</td>
                                    <td>{{ $pengembalian->peminjaman?->asset?->nama_asset ?? '-' }}</td>
                                    <td>{{ $pengembalian->jumlah_kembali ?? '-' }}</td>
                                    <td>{{ $pengembalian->peminjaman?->tanggal_pinjam ?? '-' }}</td>
                                    <td>{{ $pengembalian->peminjaman?->tanggal_kembali ?? '-' }}</td>
                                    <td>{{ $pengembalian->tanggal_pengembalian }}</td>

                                    {{-- Bagian Kondisi Aset --}}
                                    <td>
                                        @php
                                            $kondisi = strtolower($pengembalian->kondisi_asset ?? '');
                                            $warna = match ($kondisi) {
                                                'tepat waktu', 'baik' => 'success', // hijau
                                                'terlambat', 'rusak ringan' => 'warning', // kuning
                                                'rusak berat' => 'danger', // merah
                                                'hilang' => 'dark', // hitam/gelap
                                                default => 'secondary', // abu-abu
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $warna }}">
                                            {{ ucfirst($pengembalian->kondisi_asset ?? '-') }}
                                        </span>
                                    </td>


                                    <td>{{ $pengembalian->catatan_pengembalian ?? '-' }}</td>
                                    <td>
                                        @if ($pengembalian->foto_kondisi)
                                            <a href="{{ asset('storage/' . $pengembalian->foto_kondisi) }}"
                                                target="_blank">
                                                <img src="{{ asset('storage/' . $pengembalian->foto_kondisi) }}"
                                                    alt="Foto Kondisi" width="60" height="60"
                                                    style="object-fit: cover; border-radius: 4px;">
                                            </a>
                                        @else
                                            <small class="text-muted">Tidak ada</small>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</td>

                                    @auth
                                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'warga')
                                            <td class="action-cell text-center">

                                                {{-- Tombol untuk warga --}}
                                                @if (Auth::user()->role === 'warga')
                                                    <a href="{{ route('denda.form', ['id_pengembalian' => $pengembalian->id_pengembalian]) }}"
                                                        class="btn btn-sm btn-success" title="Bayar Denda">
                                                        <i class="fas fa-money-bill-wave"></i> Bayar
                                                    </a>
                                                @endif

                                                {{-- Tombol untuk admin --}}
                                                @if (Auth::user()->role === 'admin')
                                                    <form
                                                        action="{{ route('pengembalian.destroy', $pengembalian->id_pengembalian) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-icon btn-delete" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <a href="{{ route('pengembalian.edit', $pengembalian->id_pengembalian) }}"
                                                            class="btn-icon btn-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </form>
                                                @endif

                                            </td>
                                        @endif
                                    @endauth
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="empty-state text-center">
                                        <div class="empty-content">
                                            <i class="fas fa-inbox"></i>
                                            <p>Belum ada data pengembalian.</p>
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
