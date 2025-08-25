<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon">
      <img src="{{ asset('back-end/img/logo/logo_desa2.jpg') }}">
    </div>
    <div class="sidebar-brand-text mx-3">PEMINJAMAN ASET DESA</div>
  </a>

  <hr class="sidebar-divider my-0">
  <li class="nav-item active">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>DASHBOARD</span>
    </a>
  </li>

  <hr class="sidebar-divider">
  <div class="sidebar-heading">Features</div>

  @auth
    @if(Auth::user()->role === 'warga' || Auth::user()->role === 'admin')
      <!-- Manajemen Aset -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
          aria-expanded="true" aria-controls="collapseBootstrap">
          <i class="fas fa-cubes"></i>
          <span>MANAJEMEN ASET</span>
        </a>
        <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('kategori.index') }}">Kategori Aset</a>
            <a class="collapse-item" href="{{ route('asset.index') }}">Daftar Aset</a>
          </div>
        </div>
      </li>

      <!-- Form Peminjaman & Pengembalian -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true"
          aria-controls="collapseForm">
          <i class="fas fa-clipboard-check"></i>
          <span>FORM</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('peminjaman.form') }}">Form Peminjaman</a>
            <a class="collapse-item" href="{{ route('pengembalian.form') }}">Form Pengembalian</a>
          </div>
        </div>
      </li>

      <!-- Data Peminjaman & Pengembalian -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true"
          aria-controls="collapseTable">
          <i class="fas fa-clipboard-list"></i>
          <span>DATA</span>
        </a>
        <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('peminjaman.index') }}">Data Peminjaman</a>
            <a class="collapse-item" href="{{ route('pengembalian.index') }}">Data Pengembalian</a>
          </div>
        </div>
      </li>

      <!-- Denda -->
      <li class="nav-item">
        <a class="nav-link" href="{{ route('denda.index') }}">
          <i class="fas fa-money-bill-wave"></i>
          <span>DENDA</span>
        </a>
      </li>
    @endif

    @if(Auth::user()->role === 'admin')
      <!-- Akun Pengguna -->
      <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
          <i class="fas fa-fw fa-users"></i>
          <span>Akun Pengguna</span>
        </a>
      </li>
    @endif

    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pimpinan')
      <!-- Cetak Laporan -->
      <li class="nav-item">
        <a class="nav-link" href="{{ route('laporan.cetak') }}">
          <i class="fas fa-print"></i>
          <span>CETAK LAPORAN</span>
        </a>
      </li>
    @endif
  @endauth

  <hr class="sidebar-divider">
  <div class="version" id="version-ruangadmin"></div>
</ul>
<!-- Sidebar -->
