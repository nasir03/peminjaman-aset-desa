@extends('back-end.layouts.app')

@section('content')
<style>
    .container {
        max-width: 1000px;
        margin: 50px auto;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 40px 50px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h2, h3 {
        text-align: center;
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 25px;
        position: relative;
    }

    h2::after, h3::after {
        content: '';
        display: block;
        width: 60px;
        height: 3px;
        background: #3498db;
        margin: 10px auto 0;
        border-radius: 3px;
    }

    .alert-success, .alert-danger {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: 600;
    }

    .alert-success {
        background-color: #eafaf1;
        color: #27ae60;
        border: 1px solid #a2d5c6;
    }

    .alert-danger {
        background-color: #fdecea;
        color: #e74c3c;
        border: 1px solid #f5b7b1;
    }

    .profile-wrapper {
        display: flex;
        gap: 40px;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .form-section {
        flex: 1 1 60%;
    }

    .photo-section {
        flex: 1 1 30%;
        text-align: center;
    }

    .photo-box {
        width: 200px;
        height: 200px;
        margin: 0 auto 15px;
        border-radius: 50%;
        border: 4px solid #3498db;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        background-color: #f8f9fa;
    }

    .photo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .btn-delete {
        background-color: #e74c3c;
        border: none;
        color: #fff;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s ease;
    }

    .btn-delete:hover {
        background-color: #c0392b;
        transform: scale(1.05);
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .form-group {
        flex: 1 1 48%;
        margin-bottom: 20px;
    }

    .form-group.full {
        flex: 1 1 100%;
    }

    label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
        color: #34495e;
    }

    input[type="text"],
    input[type="email"],
    input[type="file"],
    input[type="password"],
    textarea,
    select {
        width: 100%;
        padding: 12px 15px;
        border-radius: 10px;
        border: 1px solid #dcdfe6;
        background-color: #fafafa;
        font-size: 15px;
        transition: 0.3s ease;
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        outline: none;
    }

    .file-info {
        font-size: 13px;
        color: #7f8c8d;
        margin-top: 5px;
    }

    .btn-primary {
        background-color: #3498db;
        border: none;
        padding: 12px 25px;
        font-weight: bold;
        font-size: 16px;
        border-radius: 10px;
        color: #fff;
        box-shadow: 0 6px 15px rgba(52, 152, 219, 0.3);
        transition: 0.3s ease;
        margin-top: 15px;
    }

    .btn-primary:hover {
        background-color: #2980b9;
        box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
        transform: translateY(-2px);
    }

    hr {
        border: none;
        border-top: 1px solid #ecf0f1;
        margin: 40px 0;
    }

    @media (max-width: 768px) {
        .profile-wrapper {
            flex-direction: column;
        }

        .form-group {
            flex: 1 1 100%;
        }

        .photo-box {
            width: 160px;
            height: 160px;
        }
    }
</style>

<div class="container">
    <h2>Profil Saya</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="profile-wrapper">
        <div class="form-section">
            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" value="{{ $user->name }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" required>
                    </div>

                    <div class="form-group">
                        <label>Peran (Role)</label>
                        <input type="text" value="{{ ucfirst($user->role) }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>No Telepon</label>
                        <input type="text" name="no_telepon" value="{{ $user->no_telepon }}">
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin">
                            <option value="laki-laki" {{ $user->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ $user->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group full">
                        <label>Alamat</label>
                        <textarea name="alamat" rows="3">{{ $user->alamat }}</textarea>
                    </div>

                    <div class="form-group full">
                        <label>Foto Profil (maks 5 MB)</label>
                        <input type="file" name="foto" id="fotoInput" accept="image/*">
                        <div class="file-info">
                            Format: JPG, JPEG, PNG. Ukuran maksimum: 5MB.
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
            </form>

            <hr>
            <h3>Ubah Kata Sandi</h3>

            <form action="{{ route('profil.updatePassword') }}" method="POST">
                @csrf
                <div class="form-group full">
                    <label>Kata Sandi Lama</label>
                    <input type="password" name="old_password" required>
                </div>

                <div class="form-group full">
                    <label>Kata Sandi Baru</label>
                    <input type="password" name="new_password" required>
                </div>

                <div class="form-group full">
                    <label>Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="new_password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary">🔐 Ubah Kata Sandi</button>
            </form>

            @if(session('password_success'))
                <div class="alert alert-success">
                    {{ session('password_success') }}
                </div>
            @endif

            @if(session('password_error'))
                <div class="alert alert-danger">
                    {{ session('password_error') }}
                </div>
            @endif
        </div>

        <div class="photo-section">
            <div class="photo-box">
                <img id="fotoPreview" src="{{ $user->foto ? asset('storage/foto_profil/' . $user->foto) : asset('images/default-user.png') }}" alt="Foto Profil">
            </div>

            @if($user->foto)
                <form action="{{ route('profil.hapusFoto') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">🗑️ Hapus Foto</button>
                </form>
            @endif
        </div>
    </div>
</div>

<script>
    document.getElementById('fotoInput').addEventListener('change', function (e) {
        const [file] = e.target.files;
        if (file) {
            document.getElementById('fotoPreview').src = URL.createObjectURL(file);
        }
    });
</script>
@endsection
