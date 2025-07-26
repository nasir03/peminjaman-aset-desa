@extends('back-end.layouts.app')

@section('content')
    <div class="container-fluid">
        <h3 class="mb-4 text-gray-800">Data Pembayaran Denda</h3>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>Nama Peminjam</th>
                                <th>Nama Aset</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Jumlah Dibayar</th>
                                <th>Metode Pembayaran</th>
                                <th>Tanggal Bayar</th>
                                <th>Bukti Pembayaran</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($denda as $item)
                                @php
                                    $pengembalian = $item->pengembalian ?? null;
                                    $peminjaman = $pengembalian->peminjaman ?? null;
                                    $user = $peminjaman->user ?? null;
                                    $asset = $peminjaman->asset ?? null;
                                @endphp

                                @if ($user && $asset)
                                    <tr class="text-center align-middle">
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $asset->nama_asset }}</td>
                                        <td>{{ $pengembalian->tanggal_pengembalian ? \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d M Y') : '-' }}
                                        </td>
                                        <td>Rp {{ number_format($item->jumlah_dibayar, 0, ',', '.') }}</td>
                                        <td>{{ $item->metode_pembayaran }}</td>
                                        <td>{{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y') : '-' }}
                                        </td>
                                        <td>
                                            @php
                                                $foto = $item->foto_pembayaran ?? null;
                                                $ext = $foto ? strtolower(pathinfo($foto, PATHINFO_EXTENSION)) : '';
                                            @endphp

                                            @if ($foto)
                                                @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                                    <a href="{{ asset('storage/' . $foto) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $foto) }}" alt="Bukti"
                                                            style="max-width: 100px; max-height: 100px;"
                                                            class="img-thumbnail">
                                                    </a>
                                                @elseif ($ext === 'pdf')
                                                    <a href="{{ asset('storage/' . $foto) }}" target="_blank">
                                                        <i class="fas fa-file-pdf text-danger fa-2x"></i><br>Lihat PDF
                                                    </a>
                                                @else
                                                    <span class="text-warning">Format tidak dikenali</span>
                                                @endif
                                            @else
                                                <span class="text-muted">Tidak tersedia</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                        <td>
                                            <form action="{{ route('pembayaran_denda.destroy', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Belum ada data pembayaran denda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
