<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Tampilkan form registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek jika akun diblokir
        if ($user && $user->is_blocked) {
            return back()->withErrors([
                'email' => '❌ Maaf, akun Anda telah diblokir oleh admin karena suatu pelanggaran.',
            ])->withInput();
        }

        // Login jika cocok
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', '✅ Berhasil login!');
        }

        return back()->withErrors([
            'email' => '⚠️ Email atau kata sandi salah.',
        ])->withInput();
    }

    // Proses registrasi user baru
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|string|min:6|confirmed',
            'no_telepon'     => 'required',
            'alamat'         => 'required',
            'jenis_kelamin'  => 'required|in:laki-laki,perempuan',
        ], [
            // ✅ Pesan kustom jika email sudah dipakai
            'email.unique' => '❌ Maaf, email Anda sudah terdaftar. Silakan gunakan email lain yang belum digunakan.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Buat user baru
        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'no_telepon'     => $request->no_telepon,
            'alamat'         => $request->alamat,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'role'           => 'warga',
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', '🎉 Registrasi berhasil! Selamat datang.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', '🔒 Berhasil logout.');
    }
}
