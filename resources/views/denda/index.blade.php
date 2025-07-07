@extends('back-end.layouts.app')

@section('content')
<div class="container">
    <h3>Data Pembayaran Denda</h3>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="custom-thead">
            <tr>
                <th>Nama Peminjam</th>
                <th>Nama Aset</th>
                <th>Tanggal Pengembalian</th>
                <th>Jumlah Dibayar</th>
                <th>Metode Pembayaran</th>
                <th>Tanggal Bayar</th>
                <th>Bukti Pembayaran</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($denda as $item)
                @if ($item->pengembalian && $item->pengembalian->peminjaman && $item->pengembalian->peminjaman->user)
                    <tr>
                        <td>{{ $item->pengembalian->peminjaman->user->name }}</td>
                        <td>{{ $item->pengembalian->peminjaman->asset->nama_asset }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->pengembalian->tanggal_pengembalian)->format('d M Y') }}</td>
                        <td>Rp {{ number_format($item->jumlah_dibayar, 0, ',', '.') }}</td>
                        <td>{{ $item->metode_pembayaran }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y') }}</td>
                        <td>
                            @if ($item->foto_pembayaran)
                                @php
                                    $ext = strtolower(pathinfo($item->foto_pembayaran, PATHINFO_EXTENSION));
                                @endphp

                                @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                    <a href="{{ asset('storage/bukti_denda/' . $item->foto_pembayaran) }}" target="_blank">
                                        <img src="{{ asset('storage/bukti_denda/' . $item->foto_pembayaran) }}" alt="Bukti" width="80">
                                    </a>
                                @elseif ($ext === 'pdf')
                                    <a href="{{ asset('storage/bukti_denda/' . $item->foto_pembayaran) }}" target="_blank">
                                        <i class="fas fa-file-pdf text-danger"></i> Lihat PDF
                                    </a>
                                @else
                                    <span class="text-warning">Format tidak dikenali</span>
                                @endif
                            @else
                                <span class="text-muted">Tidak tersedia</span>
                            @endif
                        </td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada data pembayaran denda.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
