@extends('back-end.layouts.app')
@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Peminjaman Aset Desa</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>

    <div class="row mb-3">
        @php
            $dashboardCards = [
                [
                    'title' => 'Total Peminjaman (Bulan Ini)',
                    'value' => '125',
                    'icon' => 'fas fa-calendar',
                    'color' => 'text-primary',
                    'extra' => '<div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 8.2%</span>
                        <span>Dari bulan lalu</span>
                    </div>'
                ],
                [
                    'title' => 'Aset Tersedia',
                    'value' => '87',
                    'icon' => 'fas fa-boxes',
                    'color' => 'text-success',
                    'extra' => '<div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-info mr-2"><i class="fas fa-check-circle"></i></span>
                        <span>Siap dipinjam</span>
                    </div>'
                ],
                [
                    'title' => 'Peminjam Aktif',
                    'value' => '43',
                    'icon' => 'fas fa-users',
                    'color' => 'text-info',
                    'extra' => '<div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 15.3%</span>
                        <span>Dari bulan lalu</span>
                    </div>'
                ],
                [
                    'title' => 'Permohonan Pending',
                    'value' => '12',
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

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Laporan Peminjaman Bulanan</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                             aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Menu Laporan:</div>
                            <a class="dropdown-item" href="#">Ekspor PDF</a>
                            <a class="dropdown-item" href="#">Ekspor Excel</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Pengaturan Grafik</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Asset Usage Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tingkat Penggunaan Aset</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle btn btn-primary btn-sm" href="#" role="button" id="dropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Bulan <i class="fas fa-chevron-down"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                             aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Pilih Periode</div>
                            <a class="dropdown-item" href="#">Hari Ini</a>
                            <a class="dropdown-item" href="#">Minggu</a>
                            <a class="dropdown-item active" href="#">Bulan</a>
                            <a class="dropdown-item" href="#">Tahun Ini</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $assets = [
                            ['name' => 'Tenda Pesta', 'used' => 28, 'total' => 35, 'color' => 'bg-warning'],
                            ['name' => 'Kursi Plastik', 'used' => 450, 'total' => 500, 'color' => 'bg-success'],
                            ['name' => 'Sound System', 'used' => 8, 'total' => 12, 'color' => 'bg-danger'],
                            ['name' => 'Meja Lipat', 'used' => 85, 'total' => 100, 'color' => 'bg-info'],
                            ['name' => 'Generator Listrik', 'used' => 4, 'total' => 8, 'color' => 'bg-success']
                        ];
                    @endphp

                    @foreach($assets as $asset)
                        <div class="mb-3">
                            <div class="small text-gray-500">{{ $asset['name'] }}
                                <div class="small float-right"><b>{{ $asset['used'] }} dari {{ $asset['total'] }} Unit</b></div>
                            </div>
                            <div class="progress" style="height: 12px;">
                                <div class="progress-bar {{ $asset['color'] }}" role="progressbar" 
                                     style="width: {{ ($asset['used']/$asset['total'])*100 }}%" 
                                     aria-valuenow="{{ ($asset['used']/$asset['total'])*100 }}"
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer text-center">
                    <a class="m-0 small text-primary card-link" href="#">Lihat Semua Aset <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Borrowing Records -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman Terbaru</h6>
                    <a class="m-0 float-right btn btn-danger btn-sm" href="#">Lihat Semua <i class="fas fa-chevron-right"></i></a>
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
                            @php
                                $borrowings = [
                                    ['id' => 'PD0001', 'borrower' => 'Pak Slamet', 'asset' => 'Tenda Pesta 4x6m', 'status' => 'Dikembalikan', 'badge' => 'badge-success'],
                                    ['id' => 'PD0002', 'borrower' => 'Bu Sari', 'asset' => 'Sound System Portable', 'status' => 'Sedang Dipinjam', 'badge' => 'badge-warning'],
                                    ['id' => 'PD0003', 'borrower' => 'Pak Budi', 'asset' => 'Kursi Plastik (50 unit)', 'status' => 'Menunggu Persetujuan', 'badge' => 'badge-danger'],
                                    ['id' => 'PD0004', 'borrower' => 'Bu Rina', 'asset' => 'Meja Lipat (10 unit)', 'status' => 'Disetujui', 'badge' => 'badge-info'],
                                    ['id' => 'PD0005', 'borrower' => 'Pak Joko', 'asset' => 'Generator 2500W', 'status' => 'Dikembalikan', 'badge' => 'badge-success']
                                ];
                            @endphp

                            @foreach($borrowings as $borrowing)
                                <tr>
                                    <td><a href="#">{{ $borrowing['id'] }}</a></td>
                                    <td>{{ $borrowing['borrower'] }}</td>
                                    <td>{{ $borrowing['asset'] }}</td>
                                    <td><span class="badge {{ $borrowing['badge'] }}">{{ $borrowing['status'] }}</span></td>
                                    <td><a href="#" class="btn btn-sm btn-primary">Detail</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>

        <!-- Messages From Residents-->
        <div class="col-xl-4 col-lg-5 ">
            <div class="card">
                <div class="card-header py-4 bg-primary d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-light">Pesan dari Warga</h6>
                </div>
                <div>
                    @php
                        $messages = [
                            ['title' => 'Selamat pagi, saya ingin meminjam tenda untuk acara 17 Agustus besok.', 'sender' => 'Pak Ahmad', 'time' => '30m', 'bold' => true],
                            ['title' => 'Apakah kursi plastik masih tersedia untuk acara pengajian minggu depan?', 'sender' => 'Bu Fatimah', 'time' => '45m', 'bold' => false],
                            ['title' => 'Terima kasih atas peminjaman sound system kemarin, sudah dikembalikan ya.', 'sender' => 'Pak Bambang', 'time' => '1j', 'bold' => true],
                            ['title' => 'Mohon informasi prosedur peminjaman generator untuk acara RT besok.', 'sender' => 'Bu Ani', 'time' => '2j', 'bold' => true]
                        ];
                    @endphp

                    @foreach($messages as $message)
                        <div class="customer-message align-items-center">
                            <a class="{{ $message['bold'] ? 'font-weight-bold' : '' }}" href="#">
                                <div class="text-truncate message-title">{{ $message['title'] }}</div>
                                <div class="small text-gray-500 message-time {{ $message['bold'] ? 'font-weight-bold' : '' }}">{{ $message['sender'] }} · {{ $message['time'] }}</div>
                            </a>
                        </div>
                    @endforeach

                    <div class="card-footer text-center">
                        <a class="m-0 small text-primary card-link" href="#">Lihat Semua Pesan <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Row-->

    <div class="row">
        <div class="col-lg-12 text-center">
            <p>Sistem Peminjaman Aset Desa - Memudahkan pengelolaan aset untuk kepentingan masyarakat</p>
        </div>
    </div>
</div>
@endsection