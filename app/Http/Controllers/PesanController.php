<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    // Tampilkan halaman pesan
    public function index()
    {
        $userLogin = Auth::user();

        // Jika admin: bisa kirim ke siapa pun. Jika warga: hanya bisa ke admin
        $users = $userLogin->role === 'admin'
            ? User::where('id', '!=', $userLogin->id)->get()
            : User::where('role', 'admin')->get();

        $pesans = Pesan::where(function ($query) {
                $query->where('pengirim_id', Auth::id())
                      ->orWhere('penerima_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('pesan.index', compact('users', 'pesans'));
    }

    // Kirim pesan
    public function kirim(Request $request)
    {
        $request->validate([
            'penerima_id' => 'required|exists:users,id',
            'isi_pesan' => 'required'
        ]);

        $pengirim = Auth::user();
        $penerima = User::findOrFail($request->penerima_id);

        if ($pengirim->role === 'warga' && $penerima->role !== 'admin') {
            return back()->with('error', 'Warga hanya bisa mengirim pesan ke admin.');
        }

        Pesan::create([
            'pengirim_id' => $pengirim->id,
            'penerima_id' => $penerima->id,
            'isi_pesan' => $request->isi_pesan,
            'is_read' => false,
        ]);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }

    // Ambil pesan baru (untuk notifikasi real-time)
    public function fetchPesanBaru()
    {
        $pesans = Pesan::with('pengirim')
            ->where('penerima_id', Auth::id())
            ->where('is_read', false)
            ->orderBy('created_at', 'asc')
            ->get();

        // Tandai sebagai sudah dibaca
        foreach ($pesans as $pesan) {
            $pesan->is_read = true;
            $pesan->save();
        }

        return response()->json($pesans);
    }

    // Hapus pesan tunggal
    public function hapus($id)
    {
        $pesan = Pesan::findOrFail($id);

        if (
            Auth::id() === $pesan->penerima_id ||
            Auth::id() === $pesan->pengirim_id ||
            Auth::user()->role === 'admin'
        ) {
            $pesan->delete();
            return back()->with('success', 'Pesan berhasil dihapus.');
        }

        return back()->with('error', 'Anda tidak diizinkan menghapus pesan ini.');
    }

    // Hapus semua pesan untuk user saat ini
    public function hapusSemua()
    {
        $userId = Auth::id();

        Pesan::where('pengirim_id', $userId)
            ->orWhere('penerima_id', $userId)
            ->delete();

        return back()->with('success', 'Semua pesan berhasil dihapus.');
    
}
  public function count()
    {
        $count = DB::table('pesans')
            ->where('penerima_id', Auth::id())
            ->whereNull('dibaca_pada') // kalau mau hanya pesan belum dibaca
            ->count();

        return response()->json(['count' => $count]);
    }


}
