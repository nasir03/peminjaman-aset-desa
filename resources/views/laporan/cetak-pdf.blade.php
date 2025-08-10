<!DOCTYPE html>
<html>
<head>
    <title>Laporan Aset Desa</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 12px;
            margin: 30px;
            color: #333;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            text-align: center;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }

        h4 {
            padding: 6px 12px;
            border-radius: 5px;
            margin-top: 30px;
            font-size: 15px;
            color: white;
        }

        .section-blue { background-color: #007bff; }
        .section-green { background-color: #28a745; }
        .section-yellow { background-color: #ffc107; color: #000 !important; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f2f4f8;
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fbfc;
        }
    </style>
</head>
<body>

@php
    $jenis = request('jenis');
@endphp

<div class="header">
    <h2>Laporan Data {{ ucfirst($jenis ?: 'Peminjaman') }} Aset Desa Seuat Jaya</h2>
</div>

{{-- PEMINJAMAN --}}
@if(!$jenis || $jenis === 'peminjaman')
<h4 class="section-blue">Data Peminjaman</h4>
<table>
    <thead>
        <tr>
            <th>Nama Peminjam</th>
            <th>Jenis Kelamin</th>
            <th>No Telepon</th>
            <th>Nama Aset</th>
            <th>Jumlah</th>
            <th>Keperluan</th>
            <th>Tanggal Pinjam</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($peminjaman as $data)
        <tr>
            <td>{{ $data->user->name ?? '-' }}</td>
            <td>{{ $data->user->jenis_kelamin ?? '-' }}</td>
            <td>{{ $data->user->no_telepon ?? '-' }}</td>
            <td>{{ $data->asset->nama_asset ?? '-' }}</td>
            <td>{{ $data->jumlah_pinjam ?? '-' }}</td>
            <td>{{ $data->keperluan_peminjaman ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($data->tanggal_pinjam)->format('d-m-Y') }}</td>
            <td>{{ ucfirst($data->status ?? '-') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- PENGEMBALIAN --}}
@if(!$jenis || $jenis === 'pengembalian')
<h4 class="section-green">Data Pengembalian</h4>
<table>
    <thead>
        <tr>
            <th>Nama Peminjam</th>
            <th>Jenis Kelamin</th>
            <th>No Telepon</th>
            <th>Nama Aset</th>
            <th>Jumlah</th>
           
            <th>Tanggal Kembali</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pengembalian as $data)
        <tr>
            <td>{{ $data->peminjaman->user->name ?? '-' }}</td>
            <td>{{ $data->peminjaman->user->jenis_kelamin ?? '-' }}</td>
            <td>{{ $data->peminjaman->user->no_telepon ?? '-' }}</td>
            <td>{{ $data->peminjaman->asset->nama_asset ?? '-' }}</td>
            <td>{{ $data->peminjaman->jumlah_pinjam ?? '-' }}</td>
            
            <td>{{ \Carbon\Carbon::parse($data->tanggal_kembali)->format('d-m-Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- DENDA --}}
@if(!$jenis || $jenis === 'denda')
<h4 class="section-yellow">Data Denda</h4>
<table>
    <thead>
        <tr>
            <th>Nama Peminjam</th>
            <th>Nama Aset</th>
            <th>Jumlah Denda</th>
            <th>Tanggal Pengembalian</th>
            <th>Bukti Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pengembalian as $data)
            @if($data->denda > 0)
                <tr>
                    <td>{{ $data->peminjaman->user->name ?? '-' }}</td>
                    <td>{{ $data->peminjaman->asset->nama_asset ?? '-' }}</td>
                    <td>Rp {{ number_format($data->denda ?? 0, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal_pengembalian)->format('d-m-Y') }}</td>
                    <td>{{ $data->bukti_pembayaran ?? 'Belum Upload' }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
@endif

</body>
</html>
