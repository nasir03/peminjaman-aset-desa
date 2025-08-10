@extends('back-end.layouts.app')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Peminjaman Aset Desa</h1>
    </div>

    <div class="row mb-4">

        {{-- Total Peminjaman --}}
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 4px solid #4e73df;">
                <div class="card-body text-primary">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Peminjaman</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalPeminjaman }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aset Tersedia --}}
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 4px solid #1cc88a;">
                <div class="card-body text-success">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Aset Tersedia</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $asetTersedia }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box-open fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aset Sudah Dikembalikan --}}
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 4px solid #36b9cc;">
                <div class="card-body text-info">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Aset Sudah Dikembalikan</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $asetSudahDikembalikan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total User --}}
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 4px solid #f6c23e;">
                <div class="card-body text-warning">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total User</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalUser }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- User Kena Denda --}}
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 4px solid #e74a3b;">
                <div class="card-body text-danger">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Kena Denda</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $userKenaDenda }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Permohonan Pending --}}
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 4px solid #858796;">
                <div class="card-body text-secondary">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Permohonan Pending</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $permohonanPending }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Peminjaman Ditolak --}}
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 4px solid #5a5c69;">
                <div class="card-body text-dark">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Peminjaman Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $peminjamanDitolak }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Peminjaman Disetujui --}}
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="border-left: 4px solid #1cc88a;">
                <div class="card-body text-success">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Peminjaman Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $peminjamanDisetujui }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Grafik Bulanan --}}
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Peminjaman per Bulan</h6>
                </div>
                <div class="card-body">
                    <canvas id="grafikPeminjaman"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Peminjaman Terbaru --}}
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-gradient-primary">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-history mr-2"></i> Peminjaman Terbaru
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama Peminjam</th>
                                    <th>Nama Aset</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestPeminjaman as $peminjaman)
                                    <tr>
                                        <td>{{ $peminjaman->user->name ?? '-' }}</td>
                                        <td>{{ $peminjaman->asset->nama_asset ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge 
                                                @if(strtolower($peminjaman->status) == 'disetujui') badge-success 
                                                @elseif(strtolower($peminjaman->status) == 'pending') badge-warning 
                                                @elseif(strtolower($peminjaman->status) == 'ditolak') badge-danger 
                                                @else badge-secondary @endif">
                                                {{ ucfirst($peminjaman->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada data peminjaman</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikPeminjaman').getContext('2d');
    const grafik = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($bulanLabels) !!},
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: {!! json_encode($laporanBulanan) !!},
                backgroundColor: 'rgba(78, 115, 223, 0.8)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection
