@extends('back-end.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="page-title">Daftar Pengguna</h1>

        <link rel="stylesheet" href="{{ asset('back-end/css/users/index.css') }}">

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="modern-table table table-bordered">
                        <thead class="custom-thead">
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Alamat</th>
                                <th>Jenis Kelamin</th>
                                <th>Role</th>
                                <th style="width: 130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->no_telepon ?? '-' }}</td>
                                    <td>{{ $user->alamat ?? '-' }}</td>
                                    <td>{{ ucfirst($user->jenis_kelamin ?? '-') }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td class="action-cell text-center">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn-icon btn-edit"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin hapus user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-delete" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                        {{-- Tombol Blokir atau Buka Blokir --}}
                                        <form action="{{ route('users.block', $user->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin mengubah status akun?')">
                                            @csrf
                                            <button type="submit"
                                                class="btn-icon {{ $user->is_blocked ? 'btn-success' : 'btn-warning' }}"
                                                title="{{ $user->is_blocked ? 'Buka Blokir' : 'Blokir' }}">
                                                <i class="fas {{ $user->is_blocked ? 'fa-unlock' : 'fa-ban' }}"></i>
                                            </button>
                                        </form>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
