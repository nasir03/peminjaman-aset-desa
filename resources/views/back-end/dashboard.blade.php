@extends('back-end.layouts.app')

@php
    use Carbon\Carbon;
    $bulanLabels = $laporanBulanan->pluck('bulan')->map(function ($b) {
        return Carbon::create()->month($b)->locale('id')->translatedFormat('F');
    });
@endphp

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Peminjaman Aset Desa</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="row mb-3">
        @php
            $dashboardCards = [
                [
                    'title' => 'Total Peminjaman (Bulan Ini)',
                    'value' => $totalPeminjaman,
                    'icon' => 'fas fa-calendar',
                    'color' => 'text-primary',
                    'extra' => '<div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> +%</span>
                        <span>Dari bulan lalu</span>
                    </div>'
                ],
                [
                    'title' => 'Aset Tersedia',
                    'value' => $asetTersedia,
                    'icon' => 'fas fa-boxes',
                    'color' => 'text-success',
                    'extra' => '<div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-info mr-2"><i class="fas fa-check-circle"></i></span>
                        <span>Siap dipinjam</span>
                    </div>'
                ],
                [
                    'title' => 'Peminjam Aktif',
                    'value' => $peminjamanAktif,
                    'icon' => 'fas fa-users',
                    'color' => 'text-info',
                    'extra' => '<div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> +%</span>
                        <span>Dari bulan lalu</span>
                    </div>'
                ],
                [
                    'title' => 'Permohonan Pending',
                    'value' => $permohonanPending,
                    'icon' => 'fas fa-clock',
                    'color' => 'text-warning',
                    'extra' => '<div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-warning mr-2"><i class="fas fa-exclamation-triangle"></i></span>
                        <span>Menunggu persetujuan</span>
                    </div>'
                ]
            ];
        @endphp

        @foreach($dashboardCards as $card)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">{{ $card['title'] }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $card['value'] }}</div>
                                {!! $card['extra'] !!}
                            </div>
                            <div class="col-auto">
                                <i class="{{ $card['icon'] }} fa-2x {{ $card['color'] }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Laporan Bulanan -->
        <div class="col-xl-8 col-lg-7">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Laporan Peminjaman Bulanan</h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 350px;">
                        <canvas id="laporanBulananChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penggunaan Aset -->
        <div class="col-xl-4 col-lg-5">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tingkat Penggunaan Aset</h6>
                </div>
                <div class="card-body">
                    @foreach($penggunaanAset as $aset)
                        <div class="mb-3">
                            <div class="small text-gray-500">
                                {{ $aset->nama_asset }}
                                <div class="small float-right"><b>{{ $aset->peminjaman_count }} kali dipinjam</b></div>
                            </div>
                            <div class="progress" style="height: 12px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: {{ min(($aset->peminjaman_count / max($maxUsage, 1)) * 100, 100) }}%"
                                     aria-valuenow="{{ $aset->peminjaman_count }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Peminjaman Terbaru -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman Terbaru</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>ID Peminjaman</th>
                                <th>Peminjam</th>
                                <th>Aset</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestPeminjaman as $p)
                                <tr>
                                    <td>{{ $p->id_peminjaman }}</td>
                                    <td>{{ $p->user->nama ?? '-' }}</td>
                                    <td>{{ $p->asset->nama_asset ?? '-' }}</td>
                                    <td>
                                        @php
                                            $badge = match($p->status) {
                                                'Dikembalikan' => 'badge-success',
                                                'Dipinjam' => 'badge-warning',
                                                'Menunggu Persetujuan' => 'badge-danger',
                                                'Disetujui' => 'badge-info',
                                                default => 'badge-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $badge }}">{{ $p->status }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

       
    <!-- Footer -->
    <div class="row">
        <div class="col-lg-12 text-center">
            <p>Sistem Peminjaman Aset Desa - Memudahkan pengelolaan aset untuk kepentingan masyarakat</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('laporanBulananChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($bulanLabels) !!},
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: {!! json_encode($laporanBulanan->pluck('total')) !!},
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#eaeaea' },
                    ticks: { stepSize: 1 }
                },
                x: {
                    grid: { color: '#f3f3f3' }
                }
            }
        }
    });
</script>
@endsection
