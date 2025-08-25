<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Landing Page - Sistem Aset Desa</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap & Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

  <style>
    :root {
      --primary-color: #1a365d;
      --secondary-color: #2d5aa0;
      --accent-color: #f6d55c;
      --text-dark: #2d3748;
      --text-light: #718096;
      --bg-light: #f7fafc;
      --white: #ffffff;
      --shadow-light: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --shadow-medium: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      --shadow-large: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      line-height: 1.6;
      color: var(--text-dark);
      background-color: var(--white);
      overflow-x: hidden;
    }

    h1, h2, h3, h4, h5, h6 {
      font-family: 'Playfair Display', serif;
      font-weight: 600;
      line-height: 1.2;
    }

    /* Header Styles */
    .header {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
      background: rgba(26, 54, 93, 0.95);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      transition: all 0.3s ease;
    }

    .header.scrolled {
      background: rgba(26, 54, 93, 0.98);
      box-shadow: var(--shadow-medium);
    }

    .navbar-brand {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      font-size: 1.5rem;
      color: var(--white) !important;
      text-decoration: none;
    }

    .navbar-nav .nav-link {
      color: rgba(255, 255, 255, 0.9) !important;
      font-weight: 500;
      font-size: 0.95rem;
      margin: 0 0.5rem;
      transition: all 0.3s ease;
      position: relative;
    }

    .navbar-nav .nav-link:hover {
      color: var(--accent-color) !important;
    }

    .navbar-nav .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -5px;
      left: 50%;
      background-color: var(--accent-color);
      transition: all 0.3s ease;
      transform: translateX(-50%);
    }

    .navbar-nav .nav-link:hover::after {
      width: 80%;
    }

    .btn-login {
      background: transparent;
      border: 2px solid rgba(255, 255, 255, 0.3);
      color: var(--white);
      padding: 0.5rem 1.5rem;
      border-radius: 50px;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-login:hover {
      background: var(--accent-color);
      border-color: var(--accent-color);
      color: var(--primary-color);
      transform: translateY(-2px);
    }

    /* Hero Section */
    .hero {
      min-height: 100vh;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      position: relative;
      display: flex;
      align-items: center;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.03)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.03)"/><circle cx="50" cy="10" r="1" fill="rgba(255,255,255,0.02)"/><circle cx="10" cy="60" r="1" fill="rgba(255,255,255,0.02)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
      opacity: 0.4;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      color: var(--white);
    }

    .hero h1 {
      font-size: 3.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      line-height: 1.1;
    }

    .hero p {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      color: rgba(255, 255, 255, 0.9);
      max-width: 600px;
    }

    .btn-primary-custom {
      background: linear-gradient(135deg, var(--accent-color) 0%, #f4d03f 100%);
      border: none;
      color: var(--primary-color);
      padding: 1rem 2rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      box-shadow: var(--shadow-medium);
    }

    .btn-primary-custom:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-large);
      color: var(--primary-color);
    }

    .btn-outline-custom {
      border: 2px solid rgba(255, 255, 255, 0.3);
      color: var(--white);
      padding: 1rem 2rem;
      border-radius: 50px;
      font-weight: 600;
      background: transparent;
      transition: all 0.3s ease;
    }

    .btn-outline-custom:hover {
      background: rgba(255, 255, 255, 0.1);
      border-color: var(--white);
      color: var(--white);
      transform: translateY(-2px);
    }

    .hero-image {
      position: relative;
    }

    .hero-image img {
      border-radius: 20px;
      box-shadow: var(--shadow-large);
      transform: perspective(1000px) rotateY(-5deg);
      transition: all 0.5s ease;
    }

    .hero-image:hover img {
      transform: perspective(1000px) rotateY(0deg) scale(1.02);
    }

    /* Section Styles */
    .section {
      padding: 6rem 0;
    }

    .section-title {
      text-align: center;
      margin-bottom: 4rem;
    }

    .section-title h2 {
      font-size: 3rem;
      color: var(--primary-color);
      margin-bottom: 1rem;
      position: relative;
    }

    .section-title h2::after {
      content: '';
      position: absolute;
      width: 80px;
      height: 4px;
      background: linear-gradient(135deg, var(--accent-color) 0%, #f4d03f 100%);
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      border-radius: 2px;
    }

    .section-title p {
      font-size: 1.1rem;
      color: var(--text-light);
      max-width: 600px;
      margin: 0 auto;
    }

    /* About Section */
    .about {
      background: var(--bg-light);
    }

    .about-image {
      position: relative;
      overflow: hidden;
      border-radius: 20px;
      box-shadow: var(--shadow-large);
    }

    .about-image img {
      width: 100%;
      height: 400px;
      object-fit: cover;
      transition: all 0.5s ease;
    }

    .about-image:hover img {
      transform: scale(1.05);
    }

    .about-content {
      padding-left: 2rem;
    }

    .about-content h3 {
      font-size: 2.5rem;
      color: var(--primary-color);
      margin-bottom: 1.5rem;
    }

    .about-content p {
      font-size: 1.1rem;
      color: var(--text-dark);
      margin-bottom: 1.5rem;
      line-height: 1.8;
    }

    /* Services Section */
    .service-card {
      background: var(--white);
      border-radius: 20px;
      padding: 2.5rem 2rem;
      text-align: center;
      box-shadow: var(--shadow-light);
      border: 1px solid rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
      height: 100%;
    }

    .service-card:hover {
      transform: translateY(-10px);
      box-shadow: var(--shadow-large);
      border-color: var(--accent-color);
    }

    .service-icon {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      transition: all 0.3s ease;
    }

    .service-card:hover .service-icon {
      background: linear-gradient(135deg, var(--accent-color) 0%, #f4d03f 100%);
      transform: scale(1.1);
    }

    .service-icon i {
      font-size: 2rem;
      color: var(--white);
    }

    .service-card:hover .service-icon i {
      color: var(--primary-color);
    }

    .service-card h4 {
      font-size: 1.5rem;
      color: var(--primary-color);
      margin-bottom: 1rem;
    }

    .service-card p {
      color: var(--text-light);
      line-height: 1.6;
    }

    /* How to Borrow Section */
    .how-to-borrow {
      background: var(--bg-light);
    }

    .step-item {
      background: var(--white);
      border-radius: 15px;
      padding: 1.5rem;
      margin-bottom: 1rem;
      border-left: 5px solid var(--accent-color);
      box-shadow: var(--shadow-light);
      transition: all 0.3s ease;
      position: relative;
    }

    .step-item:hover {
      transform: translateX(10px);
      box-shadow: var(--shadow-medium);
    }

    .step-number {
      position: absolute;
      left: -15px;
      top: 50%;
      transform: translateY(-50%);
      width: 30px;
      height: 30px;
      background: var(--accent-color);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      color: var(--primary-color);
      font-size: 0.9rem;
    }

    .step-item h5 {
      font-size: 1.2rem;
      color: var(--primary-color);
      margin-bottom: 0.5rem;
      margin-left: 1rem;
    }

    .step-item p {
      color: var(--text-light);
      margin-bottom: 0;
      margin-left: 1rem;
    }

    /* Contact Section */
    .contact-card {
      background: var(--white);
      border-radius: 20px;
      padding: 2.5rem 2rem;
      text-align: center;
      box-shadow: var(--shadow-light);
      transition: all 0.3s ease;
      height: 100%;
    }

    .contact-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-medium);
    }

    .contact-icon {
      width: 70px;
      height: 70px;
      background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
    }

    .contact-icon i {
      font-size: 1.8rem;
      color: var(--white);
    }

    .contact-card h4 {
      color: var(--primary-color);
      margin-bottom: 1rem;
    }

    .contact-card a {
      color: var(--secondary-color);
      text-decoration: none;
      font-weight: 500;
    }

    .contact-card a:hover {
      color: var(--accent-color);
    }

    /* Footer */
    .footer {
      background: var(--primary-color);
      color: var(--white);
      padding: 2rem 0;
      text-align: center;
    }

    .footer p {
      margin: 0;
      opacity: 0.8;
    }

    /* Scroll Top Button */
    .scroll-top {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 50px;
      height: 50px;
      background: var(--accent-color);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary-color);
      font-size: 1.2rem;
      box-shadow: var(--shadow-medium);
      transition: all 0.3s ease;
      opacity: 0;
      visibility: hidden;
    }

    .scroll-top.show {
      opacity: 1;
      visibility: visible;
    }

    .scroll-top:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-large);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2.5rem;
      }
      
      .hero p {
        font-size: 1.1rem;
      }

      .section-title h2 {
        font-size: 2.2rem;
      }

      .about-content {
        padding-left: 0;
        margin-top: 2rem;
      }

      .btn-primary-custom,
      .btn-outline-custom {
        padding: 0.8rem 1.5rem;
        font-size: 1rem;
      }
    }

    /* Animation Classes */
    .fade-in {
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.6s ease;
    }

    .fade-in.visible {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>
<body>

  <!-- Header -->
  <nav class="header navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="#hero">
        <i class="bi bi-building me-2"></i>
        Aset Desa
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <i class="bi bi-list text-white fs-4"></i>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link" href="#hero">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about">Tentang</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#services">Layanan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#how-to-borrow">Cara Peminjaman</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">Kontak</a>
          </li>
        </ul>
        
        <a href="{{ route('login') }}" class="btn btn-login">Login</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section id="hero" class="hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 hero-content" data-aos="fade-right">
          <h1>Sistem Informasi Aset Desa Seuat Jaya yang Modern dan Terintegrasi</h1>
          <p>Kelola aset, pantau peminjaman, dan cetak laporan dengan mudah melalui satu aplikasi terpadu untuk desa Anda.</p>
          <div class="d-flex flex-column flex-md-row gap-3">
            <a href="#about" class="btn btn-primary-custom">
              Pelajari Lebih Lanjut 
              <i class="bi bi-arrow-right ms-2"></i>
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-custom">Login Sekarang</a>
          </div>
        </div>
        <div class="col-lg-6 hero-image" data-aos="fade-left">
           <img src="{{ asset('landing-page/img/hape.png') }}" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="about section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6" data-aos="fade-right">
          <div class="about-image">
           <img src="{{ asset('landing-page/img/hero-img.png') }}" class="img-fluid animated" alt="">
          </div>
        </div>
        <div class="col-lg-6 about-content" data-aos="fade-left">
          <h3>Tentang Aplikasi</h3>
          <p>Sistem Informasi Aset Desa Seuat Jaya merupakan aplikasi berbasis web yang dirancang untuk mempermudah pengelolaan aset desa secara digital, efisien, dan terintegrasi.</p>
          <p>Aplikasi ini memberikan solusi lengkap mulai dari pencatatan, peminjaman, pengembalian, perhitungan denda, hingga cetak laporan aset dengan teknologi modern dan interface yang user-friendly.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" class="services section">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Layanan</h2>
        <p>Fitur unggulan yang kami sediakan untuk kemudahan pengelolaan aset desa</p>
      </div>
      
      <div class="row g-4">
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="service-card">
            <div class="service-icon">
              <i class="bi bi-clipboard-data"></i>
            </div>
            <h4>Kategori Aset</h4>
            <p>Pengelompokan aset berdasarkan jenis untuk memudahkan pendataan dan pelaporan yang sistematis.</p>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="service-card">
            <div class="service-icon">
              <i class="bi bi-arrow-left-right"></i>
            </div>
            <h4>Form Peminjaman</h4>
            <p>Ajukan peminjaman aset secara digital dan terdokumentasi dengan proses yang transparan.</p>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="service-card">
            <div class="service-icon">
              <i class="bi bi-box-arrow-in-left"></i>
            </div>
            <h4>Form Pengembalian</h4>
            <p>Pengembalian aset dengan laporan kondisi aset yang detail dan akurat.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- How to Borrow Section -->
  <section id="how-to-borrow" class="how-to-borrow section">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Cara Peminjaman Aset</h2>
        <p>Panduan resmi pengajuan peminjaman aset desa melalui sistem</p>
      </div>
      
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="step-item" data-aos="fade-up" data-aos-delay="100">
            <div class="step-number">1</div>
            <h5>Login ke Sistem</h5>
            <p>Masuk dengan akun Anda yang telah terdaftar di sistem</p>
          </div>
          
          <div class="step-item" data-aos="fade-up" data-aos-delay="200">
            <div class="step-number">2</div>
            <h5>Buka Form Peminjaman</h5>
            <p>Isi data aset yang ingin dipinjam dengan lengkap dan benar</p>
          </div>
          
          <div class="step-item" data-aos="fade-up" data-aos-delay="300">
            <div class="step-number">3</div>
            <h5>Lengkapi Data</h5>
            <p>Sertakan alasan, tanggal peminjaman, dan foto KTP sebagai identitas</p>
          </div>
          
          <div class="step-item" data-aos="fade-up" data-aos-delay="400">
            <div class="step-number">4</div>
            <h5>Kirim Permohonan</h5>
            <p>Tunggu persetujuan dari admin desa dalam waktu 1x24 jam</p>
          </div>
          
          <div class="step-item" data-aos="fade-up" data-aos-delay="500">
            <div class="step-number">5</div>
            <h5>Ambil Aset</h5>
            <p>Setelah disetujui, ambil aset sesuai jadwal yang telah ditentukan</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="contact section">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Kontak</h2>
        <p>Hubungi kami untuk bantuan atau pertanyaan lebih lanjut</p>
      </div>
      
      <div class="row g-4 justify-content-center">
        <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="contact-card">
            <div class="contact-icon">
              <i class="bi bi-person-circle"></i>
            </div>
            <h4>Admin Desa</h4>
            <p><strong>Nama:</strong> Adi Saputra</p>
            <p><strong>WhatsApp:</strong> <a href="https://wa.me/6281286116751" target="_blank">0812-8611-6751</a></p>
          </div>
        </div>
        
        <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="contact-card">
            <div class="contact-icon">
              <i class="bi bi-envelope-fill"></i>
            </div>
            <h4>Email</h4>
            <p><strong>Email:</strong> <a href="mailto:asetdesaseuat@gmail.com">asetdesaseuat@gmail.com</a></p>
            <p>Respon dalam 1x24 jam</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <p>&copy; 2024 @nasirallfin - Sistem Aset Desa Seuat Jaya</p>
    </div>
  </footer>

  <!-- Scroll Top Button -->
  <a href="#hero" class="scroll-top" id="scrollTop">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

  <script>
    // Initialize AOS
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: true
    });

    // Header scroll effect
    window.addEventListener('scroll', function() {
      const header = document.querySelector('.header');
      const scrollTop = document.getElementById('scrollTop');
      
      if (window.scrollY > 100) {
        header.classList.add('scrolled');
        scrollTop.classList.add('show');
      } else {
        header.classList.remove('scrolled');
        scrollTop.classList.remove('show');
      }
    });

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Mobile navigation toggle
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarNav = document.querySelector('#navbarNav');
    
    navbarToggler.addEventListener('click', function() {
      navbarNav.classList.toggle('show');
    });

    // Close mobile menu when clicking on links
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', function() {
        navbarNav.classList.remove('show');
      });
    });
  </script>

</body>
</html>