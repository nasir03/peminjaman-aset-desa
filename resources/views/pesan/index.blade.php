@extends('back-end.layouts.app')

@section('content')
<style>
    .pesan-container {
        background: #f8f9fc;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .chat-box {
        height: 400px;
        overflow-y: auto;
        padding: 15px;
        background-color: #ffffff;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .pesan-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .pesan-item.me {
        flex-direction: row-reverse;
        text-align: right;
    }

    .pesan-foto {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 12px;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    .pesan-isi {
        background-color: #e2e8f0;
        padding: 12px 16px;
        border-radius: 12px;
        max-width: 60%;
        word-wrap: break-word;
    }

    .pesan-item.me .pesan-isi {
        background-color: #cfe2ff;
    }

    .pesan-waktu {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 6px;
    }

    .form-pesan {
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }

    .form-pesan textarea {
        flex: 1;
        resize: none;
        height: 60px;
    }

    .btn-kirim {
        white-space: nowrap;
        height: 60px;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 5px;
    }

    .btn-hapus-semua {
        float: right;
        margin-top: 10px;
    }
</style>

<div class="container pesan-container">
    <h4 class="mb-4 font-weight-bold">💬 Kotak Pesan</h4>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Form Kirim Pesan --}}
    <div class="mb-4">
        <form method="POST" action="{{ route('pesan.kirim') }}">
            @csrf
            <div class="form-group">
                <label for="penerima">Kirim ke:</label>
                <select name="penerima_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mt-3 form-pesan">
                <textarea name="isi_pesan" class="form-control" placeholder="Tulis pesan..." required></textarea>
                <button type="submit" class="btn btn-primary btn-kirim">Kirim</button>
            </div>
        </form>
    </div>

    {{-- Daftar Pesan --}}
    <div class="chat-box">
        @forelse($pesans as $pesan)
            <div class="pesan-item {{ $pesan->pengirim_id == Auth::id() ? 'me' : '' }}">
                <img class="pesan-foto" src="{{ $pesan->pengirim->foto 
                    ? asset('storage/foto_profil/' . $pesan->pengirim->foto) 
                    : asset('images/default-user.png') }}" alt="Foto">
                <div class="pesan-isi">
                    <strong>{{ $pesan->pengirim->name }}</strong>
                    <div>{{ $pesan->isi_pesan }}</div>
                    <div class="pesan-waktu">{{ $pesan->created_at->diffForHumans() }}</div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Belum ada pesan.</p>
        @endforelse
    </div>


    {{-- Tombol Hapus Semua --}}
    <form action="{{ route('pesan.hapusSemua') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua pesan?')">
        @csrf
        <button type="submit" class="btn btn-danger btn-hapus-semua">🗑️ Hapus Semua Pesan</button>
    </form>
</div>
@endsection
