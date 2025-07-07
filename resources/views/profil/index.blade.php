@extends('back-end.layouts.app')

@section('content')
<style>
    .container {
        max-width: 1000px;
        margin: 40px auto;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        padding: 40px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h2 {
        text-align: center;
        color: #2b3e66;
        margin-bottom: 30px;
        font-weight: 700;
        border-bottom: 2px solid #dee2f1;
        padding-bottom: 10px;
    }

    .alert-success {
        background-color: #e0f8e9;
        border: 1px solid #b2e2c8;
        color: #2e7d32;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 25px;
        text-align: center;
    }

    .alert-danger {
        background-color: #fdecea;
        border: 1px solid #f5c6cb;
        color: #c0392b;
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
        text-align: center;
    }

    .profile-wrapper {
        display: flex;
        gap: 40px;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .form-section {
        flex: 1 1 60%;
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
        color: #333;
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
        border: 1px solid #ccd6dd;
        background-color: #fdfdff;
        font-size: 15px;
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.2);
        outline: none;
    }

    .photo-section {
        flex: 1 1 30%;
        text-align: center;
    }

    .photo-box {
        width: 200px;
        height: 200px;
        margin: 0 auto;
        border: 3px dashed #ccc;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f9f9f9;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 15px;
        position: relative;
    }

    .photo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .btn-delete {
        background-color: #e74c3c;
        border: none;
        color: white;
        padding: 8px 15px;
        border-radius: 8px;
        font-size: 14px;
        margin-top: 10px;
        cursor: pointer;
    }

    .btn-delete:hover {
        background-color: #c0392b;
    }

    .file-info {
        font-size: 13px;
        color: #777;
        margin-top: 5px;
    }

    .btn-primary {
        background-color: #4a90e2;
        border: none;
        padding: 12px 25px;
        font-weight: bold;
        font-size: 16px;
        border-radius: 10px;
        color: #fff;
        box-shadow: 0 6px 15px rgba(74, 144, 226, 0.3);
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #3b7cc4;
        box-shadow: 0 8px 20px rgba(74, 144, 226, 0.5);
    }

    @media (max-width: 768px) {
        .profile-wrapper {
            flex-direction: column;
            align-items: center;
        }

        .form-row {
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
            {{-- Form Profil --}}
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

            {{-- Form Ubah Password --}}
            <hr style="margin: 30px 0; border-color: #ccc;">
            <h3 style="margin-bottom: 20px; color: #2b3e66;">Ubah Kata Sandi</h3>

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
