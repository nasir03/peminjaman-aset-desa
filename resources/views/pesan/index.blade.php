@extends('back-end.layouts.app')

@section('content')
<style>
/* Professional Message Interface Styles */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    font-family: 'Inter', 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
    color: #1a202c;
    line-height: 1.6;
    min-height: 100vh;
}

.container {
    max-width: 1000px;
    margin: 20px auto;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    box-shadow: 
        0 25px 50px -12px rgba(0, 0, 0, 0.25),
        0 0 0 1px rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    overflow: hidden;
    animation: slideIn 0.6s ease-out;
    padding: 0;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Header Section */
.message-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
    color: white;
    padding: 30px 40px;
    position: relative;
    overflow: hidden;
}

.message-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
    animation: float 20s infinite linear;
}

@keyframes float {
    0% { transform: translateX(-100px); }
    100% { transform: translateX(100px); }
}

h3 {
    color: white;
    font-weight: 700;
    font-size: 28px;
    margin-bottom: 8px;
    position: relative;
    display: flex;
    align-items: center;
    gap: 12px;
}

h3::before {
    content: '💬';
    font-size: 32px;
}

h5 {
    font-size: 24px;
    color: #2d3748;
    margin-top: 40px;
    margin-bottom: 25px;
    padding: 20px 40px 0;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 12px;
}

h5::before {
    content: '📨';
    font-size: 28px;
}

/* Content Area */
.content-area {
    padding: 40px;
}

/* Form Styles */
.form-group {
    margin-bottom: 30px;
    position: relative;
}

label {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 12px;
    display: block;
    font-size: 16px;
    position: relative;
    padding-left: 8px;
}

label::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 20px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 2px;
}

select, textarea {
    width: 100%;
    padding: 18px 24px;
    font-size: 16px;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    background: rgba(247, 250, 252, 0.8);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-family: inherit;
    resize: vertical;
    position: relative;
}

select:focus,
textarea:focus {
    border-color: #667eea;
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 
        0 0 0 4px rgba(102, 126, 234, 0.1),
        0 10px 25px -5px rgba(102, 126, 234, 0.2);
    outline: none;
    transform: translateY(-2px);
}

select {
    cursor: pointer;
    appearance: none;
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%23667eea" stroke-width="2"><polyline points="6,9 12,15 18,9"/></svg>');
    background-repeat: no-repeat;
    background-position: right 20px center;
    background-size: 20px;
    padding-right: 60px;
}

textarea {
    min-height: 120px;
    line-height: 1.6;
}

/* Button Styles */
.btn {
    border: none;
    padding: 16px 32px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    position: relative;
    overflow: hidden;
    min-width: 140px;
    justify-content: center;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn:hover::before {
    left: 100%;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px -5px rgba(102, 126, 234, 0.5);
}

.btn-danger {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    color: white;
    box-shadow: 0 10px 25px -5px rgba(229, 62, 62, 0.4);
}

.btn-danger:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px -5px rgba(229, 62, 62, 0.5);
}

.btn-secondary {
    background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
    color: white;
    box-shadow: 0 10px 25px -5px rgba(113, 128, 150, 0.4);
    font-size: 14px;
    padding: 12px 24px;
    margin-bottom: 20px;
}

.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px -5px rgba(113, 128, 150, 0.5);
}

.btn-sm {
    padding: 10px 20px;
    font-size: 14px;
    min-width: 120px;
}

/* Message Cards */
.pesan-wrapper {
    margin-top: 40px;
    padding-top: 20px;
    border-top: 2px solid #e2e8f0;
}

.pesan-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(247,250,252,0.9) 100%);
    border: 1px solid rgba(226, 232, 240, 0.8);
    border-left: 6px solid #667eea;
    border-radius: 20px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 
        0 4px 20px rgba(0, 0, 0, 0.08),
        0 0 0 1px rgba(255, 255, 255, 0.5);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.pesan-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
    background-size: 200% 100%;
    animation: shimmer 3s ease-in-out infinite;
}

@keyframes shimmer {
    0%, 100% { background-position: 200% 0; }
    50% { background-position: -200% 0; }
}

.pesan-card:hover {
    transform: translateY(-5px);
    box-shadow: 
        0 15px 35px rgba(0, 0, 0, 0.12),
        0 0 0 1px rgba(255, 255, 255, 0.8);
    border-left-color: #764ba2;
}

.pesan-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 12px;
    border-bottom: 1px solid rgba(226, 232, 240, 0.6);
}

.pengirim-nama {
    font-weight: 700;
    color: #1e3a8a;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.waktu {
    color: #718096;
    font-size: 14px;
    font-weight: 500;
    background: rgba(113, 128, 150, 0.1);
    padding: 6px 12px;
    border-radius: 20px;
}

.isi-pesan {
    font-size: 16px;
    color: #2d3748;
    line-height: 1.7;
    background: rgba(255, 255, 255, 0.7);
    padding: 20px;
    border-radius: 12px;
    border: 1px solid rgba(226, 232, 240, 0.5);
    margin-top: 15px;
}

/* Alert Styles */
.alert-success {
    background: linear-gradient(135deg, rgba(56, 178, 172, 0.1) 0%, rgba(56, 178, 172, 0.05) 100%);
    border: 1px solid rgba(56, 178, 172, 0.2);
    border-left: 6px solid #38b2ac;
    padding: 20px 25px;
    border-radius: 16px;
    color: #234e52;
    margin-bottom: 25px;
    font-weight: 500;
    box-shadow: 0 4px 15px rgba(56, 178, 172, 0.1);
}

.empty-message {
    color: #a0aec0;
    text-align: center;
    font-style: italic;
    font-size: 18px;
    padding: 60px 20px;
    background: rgba(247, 250, 252, 0.5);
    border-radius: 16px;
    border: 2px dashed #e2e8f0;
}

/* Utility Classes */
.mt-4 { margin-top: 2rem; }
.mb-2 { margin-bottom: 0.5rem; }
.mb-3 { margin-bottom: 1rem; }

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        margin: 10px;
        border-radius: 20px;
    }
    
    .content-area {
        padding: 25px;
    }
    
    .message-header {
        padding: 25px;
    }
    
    h3 {
        font-size: 24px;
    }
    
    h5 {
        font-size: 20px;
        padding: 15px 25px 0;
    }
    
    .pesan-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}

/* Focus Accessibility */
.btn:focus,
select:focus,
textarea:focus {
    outline: 3px solid rgba(102, 126, 234, 0.5);
    outline-offset: 2px;
}
</style>

<div class="container">
    {{-- Header Section --}}
    <div class="message-header">
        <h3>Kirim Pesan</h3>
    </div>

    <div class="content-area">
        {{-- Audio --}}
        <audio id="notifSound" src="{{ asset('back-end/sound/pesan.mp3') }}" preload="auto"></audio>

        <button id="testSoundBtn" class="btn btn-sm btn-secondary mb-3">🔊 Tes Suara</button>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('pesan.kirim') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="penerima_id">Kirim ke:</label>
                <select name="penerima_id" required>
                    @foreach($users as $user)
                        @if(Auth::user()->role === 'admin' || $user->role === 'admin')
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="isi_pesan">Isi Pesan:</label>
                <textarea name="isi_pesan" rows="4" required placeholder="Tulis pesan Anda di sini..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary">✉️ Kirim Pesan</button>
        </form>

        @if(count($pesans) > 0)
            <form action="{{ route('pesan.hapusSemua') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua pesan?')">
                @csrf
                <button type="submit" class="btn btn-danger mt-4 mb-2">🗑️ Hapus Semua Pesan</button>
            </form>
        @endif
    </div>

    <div class="pesan-wrapper">
        <h5>Pesan Masuk</h5>
        <div style="padding: 0 40px 40px;">
            @forelse($pesans as $pesan)
                <div class="pesan-card">
                    <div class="pesan-header">
                        <span class="pengirim-nama">👤 {{ $pesan->pengirim->name }}</span>
                        <span class="waktu">{{ $pesan->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="isi-pesan">{{ $pesan->isi_pesan }}</div>
                </div>
            @empty
                <p class="empty-message">Belum ada pesan masuk.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const notifSound = document.getElementById('notifSound');
    let lastPesanCount = {{ count($pesans) }};

    document.getElementById('testSoundBtn').addEventListener('click', function () {
        notifSound.play().catch(e => {
            console.warn("Gagal memutar suara:", e);
        });
    });

    document.addEventListener('click', function () {
        notifSound.play().then(() => notifSound.pause());
    }, { once: true });

    function fetchPesanBaru() {
        $.ajax({
            url: "{{ route('pesan.fetch') }}",
            method: "GET",
            success: function (data) {
                if (data.length > lastPesanCount) {
                    notifSound.play();
                    location.reload();
                }
                lastPesanCount = data.length;
            }
        });
    }

    setInterval(fetchPesanBaru, 5000);
</script>
@endsection