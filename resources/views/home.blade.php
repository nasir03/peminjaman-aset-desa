<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Landing Page - Sistem Aset Desa</title>

  <link href="{{ asset('landing-page/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('landing-page/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

  <link href="{{ asset('landing-page/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('landing-page/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('landing-page/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('landing-page/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('landing-page/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <link href="{{ asset('landing-page/css/main.css') }}" rel="stylesheet">
</head>
<body class="index-page">

  <!-- Header -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="{{ url('/') }}" class="logo d-flex align-items-center">
        <img src="{{ asset('landing-page/img/logo.png') }}" alt="Logo">
        <h1 class="sitename">Aset Desa</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <li><a href="#about">Tentang</a></li>
          <li><a href="#services">Layanan</a></li>
          <li><a href="#contact">Kontak</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      @auth
        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
      @else
        <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
      @endauth
    </div>
  </header>

  <!-- Hero Section -->
  <section id="hero" class="hero section">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h1 data-aos="fade-up">Sistem Informasi Aset Desa Seuat Jaya yang Modern dan Terintegrasi</h1>
          <p data-aos="fade-up" data-aos-delay="100">Kelola aset, pantau peminjaman, dan cetak laporan dengan mudah melalui satu aplikasi terpadu untuk desa Anda.</p>
          <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
            <a href="#about" class="btn-get-started">Pelajari Lebih Lanjut <i class="bi bi-arrow-right"></i></a>
            <a href="{{ route('login') }}" class="btn btn-outline-primary ms-md-3 mt-3 mt-md-0">Login</a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
          <img src="{{ asset('landing-page/img/hero-img.png') }}" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="about section">
    <div class="container" data-aos="fade-up">
      <div class="row">
        <div class="col-lg-6">
          <img src="{{ asset('landing-page/img/about.jpg') }}" class="img-fluid" alt="">
        </div>
        <div class="col-lg-6 pt-4 pt-lg-0 content">
          <h3>Tentang Aplikasi</h3>
          <p>
            Sistem Informasi Aset Desa Seuat Jaya merupakan aplikasi berbasis web yang dirancang untuk mempermudah pengelolaan aset desa secara digital, efisien, dan terintegrasi. Aplikasi ini memberikan solusi lengkap dalam mengelola berbagai jenis aset milik desa, mulai dari pencatatan kategori aset, proses peminjaman dan pengembalian aset, penghitungan serta pembayaran denda jika terjadi kerusakan atau kehilangan, hingga manajemen akun pengguna.
          </p>
          <p>
            Tidak hanya itu, aplikasi ini juga dilengkapi dengan fitur cetak laporan yang memudahkan perangkat desa dalam menyusun laporan aset untuk kebutuhan administrasi atau pelaporan ke pihak yang berwenang. Dengan tampilan yang modern dan penggunaan yang mudah, aplikasi ini sangat cocok digunakan oleh pemerintahan desa untuk meningkatkan transparansi dan akuntabilitas.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" class="services section">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Layanan</h2>
        <p>Fitur yang kami sediakan</p>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
          <div class="icon-box">
            <div class="icon"><i class="bi bi-clipboard-data"></i></div>
            <h4><a href="#">Kategori Aset</a></h4>
            <p>Pengelompokan aset berdasarkan jenis seperti aset tetap, tidak tetap, atau aset khusus desa untuk memudahkan pendataan dan pelaporan.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
          <div class="icon-box">
            <div class="icon"><i class="bi bi-arrow-left-right"></i></div>
            <h4><a href="#">Form Peminjaman</a></h4>
            <p>Fitur digital untuk mengajukan permintaan peminjaman aset secara mudah, cepat, dan terdokumentasi dengan notifikasi ke admin.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
          <div class="icon-box">
            <div class="icon"><i class="bi bi-box-arrow-in-left"></i></div>
            <h4><a href="#">Form Pengembalian</a></h4>
            <p>Digunakan untuk proses pengembalian aset oleh pengguna setelah digunakan, disertai dengan laporan kondisi aset.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <div class="icon-box">
            <div class="icon"><i class="bi bi-cash-coin"></i></div>
            <h4><a href="#">Denda</a></h4>
            <p>Fitur perhitungan otomatis dan pencatatan denda jika terjadi keterlambatan pengembalian, kerusakan, atau kehilangan aset.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <div class="icon-box">
            <div class="icon"><i class="bi bi-person-lines-fill"></i></div>
            <h4><a href="#">Akun Pengguna</a></h4>
            <p>Manajemen akun pengguna berdasarkan peran (admin/warga), termasuk fitur tambah, edit, hapus, dan reset kata sandi.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <div class="icon-box">
            <div class="icon"><i class="bi bi-file-earmark-text"></i></div>
            <h4><a href="#">Laporan</a></h4>
            <p>Cetak laporan data aset, peminjaman, pengembalian, dan denda berdasarkan periode waktu secara otomatis dalam format PDF.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="contact section">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Kontak</h2>
        <p>Hubungi kami untuk bantuan atau pertanyaan lebih lanjut</p>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="info-box">
            <i class="bi bi-person-circle"></i>
            <h3>Admin Desa</h3>
            <p>Nama: Adi Saputra<br>
              No. WhatsApp: <a href="https://wa.me/6281286116751" target="_blank">0812-8611-6751</a><br>
              Instagram: <a href="https://instagram.com/adi_saputra" target="_blank">@adi_saputra</a><br>
              Facebook: <a href="https://facebook.com/adi.saputra" target="_blank">Adi.Saputra</a>
            </p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="info-box">
            <i class="bi bi-envelope-fill"></i>
            <h3>Email</h3>
            <p>asetdesa@example.com</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer id="footer" class="footer">
    <div class="container text-center">
      <p>&copy; {{ date('Y') }} @nasirallfin</p>
    </div>
  </footer>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="{{ asset('landing-page/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('landing-page/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('landing-page/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('landing-page/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('landing-page/js/main.js') }}"></script>
</body>
</html>
