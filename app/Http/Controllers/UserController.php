<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // ====================================================
    // 2. HALAMAN PROFIL USER LOGIN & UPDATE PROFIL
    // ====================================================
    public function profil()
    {
        $user = Auth::user();
        return view('profil.index', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $user->fill($request->only(['name', 'email', 'no_telepon', 'alamat', 'jenis_kelamin']));

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/foto_profil'), $filename);

            // Hapus foto lama jika ada
            if ($user->foto && file_exists(public_path('storage/foto_profil/' . $user->foto))) {
                unlink(public_path('storage/foto_profil/' . $user->foto));
            }

            $user->foto = $filename;
        }

        $user->save();

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui!');
    }

    // ====================================================
    // 3. KELOLA DAFTAR PENGGUNA (KHUSUS ADMIN)
    // ====================================================
    public function index()
    {
        $users = User::whereIn('role', ['admin', 'warga', 'pimpinan'])->get();
        return view('users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'role' => 'required|in:admin,warga,pimpinan',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'no_telepon', 'alamat', 'jenis_kelamin', 'role']));

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus foto profil jika ada
        if ($user->foto && file_exists(public_path('storage/foto_profil/' . $user->foto))) {
            unlink(public_path('storage/foto_profil/' . $user->foto));
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
    public function hapusFoto()
    {
        $user = Auth::user();
        if ($user->foto && file_exists(public_path('storage/foto_profil/' . $user->foto))) {
            unlink(public_path('storage/foto_profil/' . $user->foto));
            $user->foto = null;
            $user->save();
        }

        return redirect()->route('profil.index')->with('success', 'Foto profil berhasil dihapus.');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('password_error', 'Kata sandi lama tidak sesuai.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('password_success', 'Kata sandi berhasil diubah.');
    }
    public function toggleBlock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        $status = $user->is_blocked ? 'diblokir' : 'dibuka blokirnya';
        return redirect()
            ->back()
            ->with('success', "Akun {$user->name} berhasil $status.");
    }
}
