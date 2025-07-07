<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Sistem Aset Desa</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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

    .floating-particles {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 0;
    }

    .particle {
      position: absolute;
      font-size: 20px;
      opacity: 0.3;
      animation: floatUp 8s linear infinite;
    }

    @keyframes floatUp {
      0% { transform: translateY(100vh) rotate(0deg); opacity: 0.3; }
      100% { transform: translateY(-10vh) rotate(360deg); opacity: 0; }
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
      flex-direction: row-reverse;
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(15px);
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      max-width: 960px;
      width: 100%;
      transform: translateX(100%);
      animation: slidePanels 1.2s ease forwards;
    }

    @keyframes slidePanels {
      0% { transform: translateX(100%); opacity: 0; }
      50% { transform: translateX(-5%); opacity: 0.6; }
      100% { transform: translateX(0); opacity: 1; }
    }

    .left-panel, .right-panel {
      flex: 1;
      padding: 60px;
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
      font-size: 32px;
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
      padding: 14px 18px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 16px;
      transition: border 0.3s;
    }

    .form-group input:focus {
      outline: none;
      border-color: #4CAF50;
      box-shadow: 0 0 8px rgba(76, 175, 80, 0.2);
    }

    .register-btn {
      width: 100%;
      padding: 16px;
      border: none;
      background: linear-gradient(135deg, #4CAF50, #66bb6a);
      color: white;
      font-size: 17px;
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

    .register-link {
      margin-top: 20px;
      text-align: center;
      font-size: 15px;
    }

    .register-link a {
      color: #4CAF50;
      text-decoration: none;
      font-weight: bold;
    }

    .register-link a:hover {
      text-decoration: underline;
    }

    .custom-alert {
      background-color: #fdecea;
      color: #b71c1c;
      border: 1px solid #f5c6cb;
      padding: 12px 16px;
      border-radius: 10px;
      margin: 20px 60px -10px 60px;
      font-size: 14px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .custom-alert ul {
      padding-left: 20px;
      margin: 0;
    }

    .custom-alert li::before {
      content: '⚠️ ';
      margin-right: 5px;
    }

    @media (max-width: 768px) {
      .register-card {
        flex-direction: column;
      }

      .left-panel {
        height: 200px;
      }

      .custom-alert {
        margin: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="animated-bg"></div>
  <div class="floating-particles" id="particles"></div>

  @if($errors->any())
    <div class="custom-alert">
      <ul>
        @foreach($errors->all() as $error)
          <li>{!! $error !!}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="register-container">
    <div class="register-card" id="registerCard">
      <div class="left-panel"></div>
      <div class="right-panel">
        <h1>Login Sistem</h1>
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group">
            <label for="email">Alamat Email</label>
            <input type="email" id="email" name="email" required>
          </div>

          <div class="form-group">
            <label for="password">Kata Sandi</label>
            <div style="position: relative;">
              <input type="password" id="password" name="password" class="form-control" required style="padding-right: 40px;">
              <span onclick="togglePassword()" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                <i class="fas fa-eye" id="toggleEye"></i>
              </span>
            </div>
          </div>

          <button type="submit" class="register-btn">🔐 Masuk Sistem</button>
        </form>
        <div class="register-link">
          Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    const particleContainer = document.getElementById('particles');
    const icons = ['🌿', '🏡', '📜', '📦', '🛠️', '🧾', '💼'];

    setInterval(() => {
      const particle = document.createElement('div');
      particle.classList.add('particle');
      particle.textContent = icons[Math.floor(Math.random() * icons.length)];
      particle.style.left = Math.random() * 100 + 'vw';
      particle.style.top = '100vh';
      particle.style.fontSize = (18 + Math.random() * 10) + 'px';
      particleContainer.appendChild(particle);
      setTimeout(() => particle.remove(), 8000);
    }, 1000);

    function togglePassword() {
      const password = document.getElementById('password');
      const eyeIcon = document.getElementById('toggleEye');
      const isPassword = password.getAttribute('type') === 'password';
      password.setAttribute('type', isPassword ? 'text' : 'password');
      eyeIcon.classList.toggle('fa-eye');
      eyeIcon.classList.toggle('fa-eye-slash');
    }
  </script>
</body>
</html>
