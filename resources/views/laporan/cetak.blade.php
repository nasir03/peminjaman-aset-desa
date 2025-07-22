@extends('back-end.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Laporan Data Aset Desa</h1>

    @php
        $jenis = request('jenis');
    @endphp

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">Filter Laporan</div>
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET" class="row">
                <div class="col-md-3 mb-2">
                    <label for="bulan">Bulan</label>
                    <select name="bulan" id="bulan" class="form-control">
                        <option value="">Semua</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <label for="tahun">Tahun</label>
                    <select name="tahun" id="tahun" class="form-control">
                        <option value="">Semua</option>
                        @php
                            $tahunSekarang = date('Y');
                            for ($tahun = $tahunSekarang; $tahun >= 2020; $tahun--) {
                                echo '<option value="'.$tahun.'"'.(request('tahun') == $tahun ? ' selected' : '').'>'.$tahun.'</option>';
                            }
                        @endphp
                    </select>
                </div>

                <div class="col-md-4 mb-2">
                    <label for="jenis">Jenis Laporan</label>
                    <select name="jenis" id="jenis" class="form-control">
                        <option value="">Semua</option>
                        <option value="peminjaman" {{ $jenis == 'peminjaman' ? 'selected' : '' }}>Peminjaman</option>
                        <option value="pengembalian" {{ $jenis == 'pengembalian' ? 'selected' : '' }}>Pengembalian</option>
                        <option value="denda" {{ $jenis == 'denda' ? 'selected' : '' }}>Denda</option>
                    </select>
                </div>

                <div class="col-md-2 mb-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tombol Cetak PDF --}}
    <div class="mb-3">
        <a href="{{ route('laporan.pdf', request()->query()) }}" target="_blank" class="btn btn-sm btn-danger">
            <i class="fas fa-file-pdf"></i> Cetak PDF
        </a>
    </div>

    {{-- Data Peminjaman --}}
    @if(!$jenis || $jenis === 'peminjaman')
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Data Peminjaman</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Jenis Kelamin</th>
                            <th>No Telepon</th>
                            <th>Nama Aset</th>
                            <th>Jumlah Pinjam</th>
                            <th>Keperluan</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman as $data)
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
                        @empty
                            <tr><td colspan="8" class="text-center">Tidak ada data peminjaman.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Data Pengembalian --}}
    @if(!$jenis || $jenis === 'pengembalian')
    <div class="card mb-4">
        <div class="card-header bg-success text-white">Data Pengembalian</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Jenis Kelamin</th>
                            <th>No Telepon</th>
                            <th>Nama Aset</th>
                            <th>Jumlah Pinjam</th>
                            <th>Catatan</th>
                            <th>Tanggal Kembali</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalian as $data)
                            <tr>
                                <td>{{ $data->peminjaman->user->name ?? '-' }}</td>
                                <td>{{ $data->peminjaman->user->jenis_kelamin ?? '-' }}</td>
                                <td>{{ $data->peminjaman->user->no_telepon ?? '-' }}</td>
                                <td>{{ $data->peminjaman->asset->nama_asset ?? '-' }}</td>
                                <td>{{ $data->peminjaman->jumlah_pinjam ?? '-' }}</td>
                                <td>{{ $data->peminjaman->catatan_admin ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->tanggal_pengembalian)->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">Tidak ada data pengembalian.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

   {{-- Data Denda --}}
@if(!$jenis || $jenis === 'denda')
<div class="card mb-5">
    <div class="card-header bg-danger text-white">Data Denda</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama Peminjam</th>
                        <th>Nama Aset</th>
                        <th>Jumlah Denda</th>
                        <th>Tanggal Pengembalian</th>
                       
                    </tr>
                </thead>
                <tbody>
                   @foreach($pengembalian as $data)
    @if($data->denda) {{-- Jika relasi denda ada --}}
        <tr>
            <td>{{ $data->peminjaman->user->name ?? '-' }}</td>
            <td>{{ $data->peminjaman->asset->nama_asset ?? '-' }}</td>
           <td>Rp {{ number_format($data->denda ?? 0, 0, ',', '.') }}</td>
            <td>{{ \Carbon\Carbon::parse($data->tanggal_pengembalian)->format('d-m-Y') }}</td>
           
        </tr>
    @endif
@endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endif


</div>
@endsection
