<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registrasi - Sistem Aset Desa</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f4f1;
      overflow-x: hidden;
      height: 100vh;
    }
    .error-message-box {
  background-color: #ffe6e6;
  color: #a94442;
  border: 1px solid #f5c6cb;
  padding: 15px 20px;
  border-radius: 8px;
  margin-bottom: 20px;
  font-size: 15px;
  line-height: 1.5;
}

.error-message-box p {
  margin: 0 0 8px 0;
}

.error-message-box p:last-child {
  margin-bottom: 0;
}


    .animated-bg {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(-45deg, #a8edea, #fed6e3, #d3f8e2, #e4c1f9);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
      z-index: -1;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .register-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding: 40px;
    }

    .register-card {
      display: flex;
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(15px);
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      max-width: 960px;
      width: 100%;
      animation: slideIn 1.5s ease;
    }

    @keyframes slideIn {
      0% { opacity: 0; transform: translateY(50px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    .left-panel, .right-panel {
      flex: 1;
      padding: 40px;
    }

    .left-panel {
      background: url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d') center/cover no-repeat;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .left-panel h2 {
      font-size: 32px;
      font-weight: bold;
      margin-bottom: 20px;
      text-shadow: 1px 1px 4px rgba(0,0,0,0.4);
    }

    .left-panel p {
      text-align: center;
      max-width: 300px;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }

    .right-panel h1 {
      font-size: 28px;
      color: #2d3e50;
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #333;
      font-weight: 600;
    }
    
    .form-group input {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 16px;
      transition: border 0.3s;
    }
    .custom-select {
  width: 100%;
  border-radius: 10px;
  padding: 12px 16px;
  border: 1px solid #ccc;
  font-size: 16px;
  transition: border-color 0.3s, box-shadow 0.3s;
}

.custom-select:focus {
  border-color: #4CAF50;
  box-shadow: 0 0 8px rgba(76, 175, 80, 0.2);
  outline: none;
}


    .form-group input:focus {
      outline: none;
      border-color: #4CAF50;
      box-shadow: 0 0 8px rgba(76, 175, 80, 0.2);
    }

    .register-btn {
      width: 100%;
      padding: 15px;
      border: none;
      background: linear-gradient(135deg, #4CAF50, #66bb6a);
      color: white;
      font-size: 16px;
      font-weight: bold;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .register-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: rgba(255,255,255,0.3);
      transform: skewX(-20deg);
      transition: left 0.6s;
    }

    .register-btn:hover::before {
      left: 100%;
    }

    .register-btn:hover {
      box-shadow: 0 8px 20px rgba(76, 175, 80, 0.4);
      transform: translateY(-2px);
    }

    @media (max-width: 768px) {
      .register-card {
        flex-direction: column;
      }

      .left-panel {
        height: 200px;
      }
      
    }
  </style>
</head>
<body>
  <div class="animated-bg"></div>

  @if($errors->any())
  <div class="error-message-box">
    @foreach($errors->all() as $error)
      <p>{!! $error !!}</p>
    @endforeach
  </div>
@endif




  <div class="register-container">
    <div class="register-card">
      <div class="left-panel">
      </div>
      <div class="right-panel">
        <h1>Formulir Registrasi</h1>
        <form method="POST" action="{{ route('register') }}">
          @csrf
          <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" required>
          </div>

          <div class="form-group">
  <label for="no_telepon">No. Telepon</label>
  <input type="text" id="no_telepon" name="no_telepon" required>
</div>

<div class="form-group">
  <label for="alamat">Alamat</label>
  <input type="text" id="alamat" name="alamat" required>
</div>

<div class="form-group">
  <label for="jenis_kelamin">Jenis Kelamin</label>
  <select id="jenis_kelamin" name="jenis_kelamin" class="custom-select" required>
    <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
    <option value="laki-laki">Laki-laki</option>
    <option value="perempuan">Perempuan</option>
  </select>
</div>


          <div class="form-group">
            <label for="email">Alamat Email</label>
            <input type="email" id="email" name="email" required>
          </div>

         <!-- Tambahkan di <head> jika belum ada Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<!-- Input Kata Sandi -->
<div class="form-group">
  <label for="password">Kata Sandi</label>
  <div style="position: relative;">
    <input type="password" id="password" name="password" class="form-control" required style="padding-right: 40px;">
    <span onclick="togglePassword('password', 'toggleEye')" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
      <i class="fas fa-eye" id="toggleEye"></i>
    </span>
  </div>
</div>

<!-- Input Konfirmasi Kata Sandi -->
<div class="form-group">
  <label for="password_confirmation">Konfirmasi Sandi</label>
  <div style="position: relative;">
    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required style="padding-right: 40px;">
    <span onclick="togglePassword('password_confirmation', 'toggleEyeConfirm')" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
      <i class="fas fa-eye" id="toggleEyeConfirm"></i>
    </span>
  </div>
</div>

<!-- Script toggle -->
<script>
  function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    const isPassword = input.getAttribute('type') === 'password';

    input.setAttribute('type', isPassword ? 'text' : 'password');
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
  }
</script>


          <button type="submit" class="register-btn">
            ✨ Daftar Sekarang
          </button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
