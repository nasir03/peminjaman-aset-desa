<!-- TopBar -->
<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-1 small"
                            placeholder="What do you want to look for?" aria-label="Search"
                            aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        @php use Carbon\Carbon; @endphp


   {{-- NOTIFIKASI  --}}
@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    $user = Auth::user();

    $notifikasiPeminjaman = DB::table('notifications')
        ->join('users', 'notifications.id_user', '=', 'users.id')
        ->where('notifications.penerima_id', $user->id)
        ->where('notifications.dibaca', false)
        ->orderByDesc('notifications.created_at')
        ->select('notifications.*', 'users.name as nama_user')
        ->get();
@endphp

<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        @if ($notifikasiPeminjaman->count() > 0)
            <span class="badge badge-danger badge-counter" data-last-id="{{ $notifikasiPeminjaman->first()->id }}">
                {{ $notifikasiPeminjaman->count() }}
            </span>
        @endif
    </a>

    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">Notifikasi</h6>

        @forelse($notifikasiPeminjaman as $notif)
            <a class="dropdown-item d-flex align-items-center" href="{{ route('peminjaman.index') }}">
                <div class="mr-3">
                    <div class="icon-circle 
                        @if($notif->tipe == 'peminjaman') bg-info 
                        @elseif($notif->tipe == 'pengembalian') bg-success 
                        @elseif($notif->tipe == 'denda') bg-danger 
                        @elseif($notif->tipe == 'pengingat') bg-warning
                        @else bg-secondary 
                        @endif">
                        <i class="fas fa-bell text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">
                        {{ \Carbon\Carbon::parse($notif->created_at)->timezone('Asia/Jakarta')->translatedFormat('d M Y H:i') }}
                    </div>

                    <span class="font-weight-bold">
                        {{ $notif->pesan }}
                    </span>
                </div>
            </a>
        @empty
            <a class="dropdown-item text-center small text-gray-500">Tidak ada notifikasi</a>
        @endforelse

        <a class="dropdown-item text-center small text-gray-500" href="{{ route('peminjaman.index') }}">Lihat Semua</a>
    </div>
</li>

        </a>
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="alertsDropdown">

            <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                </div>

            </a>
            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
        </div>
        </li>
        <li class="nav-item dropdown no-arrow mx-1">

<!-- Ikon pesan dan jumlah pesan -->
<a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-envelope fa-fw"></i>

    @isset($pesans)
        @php $jumlahPesan = $pesans->count(); @endphp
        @if ($jumlahPesan > 0)
            <span class="badge badge-warning badge-counter" id="messageCount">{{ $jumlahPesan }}</span>
        @else
            <span class="badge badge-warning badge-counter d-none" id="messageCount">0</span>
        @endif
    @else
        <span class="badge badge-warning badge-counter d-none" id="messageCount">0</span>
    @endisset
</a>

<!-- Dropdown Pesan -->
<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
    aria-labelledby="messagesDropdown">

    <h6 class="dropdown-header">Message Center</h6>

    @isset($pesans)
        @forelse($pesans->take(5) as $pesan)
            <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="{{ $pesan->pengirim->foto ?? asset('img/default.png') }}"
                        style="max-width: 60px;" alt="Foto Pengirim">
                    <div class="status-indicator bg-success"></div>
                </div>
                <div class="font-weight-bold">
                    <div class="text-truncate">{{ Str::limit($pesan->isi_pesan, 50) }}</div>
                    <div class="small text-gray-500">
                        {{ $pesan->pengirim->name ?? 'Tidak diketahui' }} ·
                        {{ $pesan->created_at->diffForHumans() }}
                    </div>
                </div>
            </a>
        @empty
            <div class="dropdown-item text-center small text-gray-500">
                Tidak ada pesan baru
            </div>
        @endforelse
    @else
        <div class="dropdown-item text-center small text-gray-500">
            Gagal memuat pesan
        </div>
    @endisset

    <a class="dropdown-item text-center small text-gray-500" href="{{ route('pesan.index') }}">
        Lihat Semua Pesan
    </a>
</div>




        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-tasks fa-fw"></i>
                <span class="badge badge-success badge-counter">3</span>
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Task
                </h6>
                <a class="dropdown-item align-items-center" href="#">
                    <div class="mb-3">
                        <div class="small text-gray-500">Design Button
                            <div class="small float-right"><b>50%</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 50%"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item align-items-center" href="#">
                    <div class="mb-3">
                        <div class="small text-gray-500">Make Beautiful Transitions
                            <div class="small float-right"><b>30%</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 30%"
                                aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item align-items-center" href="#">
                    <div class="mb-3">
                        <div class="small text-gray-500">Create Pie Chart
                            <div class="small float-right"><b>75%</b></div>
                        </div>
                        <div class="progress" style="height: 12px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 75%"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">View All Taks</a>
            </div>
       <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

        <img class="img-profil"
            src="{{ Auth::user()->foto ? asset('storage/foto_profil/' . Auth::user()->foto) : asset('back-end/img/boy.png') }}"
            alt="Foto Profil">

        <span class="ml-2 d-none d-lg-inline text-white"
            style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; font-weight: 600;">
            {{ Auth::user()->name }}
        </span>
    </a>

    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="{{ route('profil.index') }}">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profil
        </a>


<style>
    .img-profil {
        width: 40px;
        height: 40px;
        border-radius: 50%; /* bulat sempurna */
        object-fit: cover;  /* isi penuh tanpa distorsi */
        border: 2px solid #fff; /* garis pinggir putih biar rapi */
        box-shadow: 0 2px 6px rgba(0,0,0,0.15); /* bayangan lembut */
    }

    .img-profil:hover {
        transform: scale(1.05);
        transition: all 0.2s ease-in-out;
    }
</style>


                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>


    </ul>
</nav>
<!-- Topbar -->
