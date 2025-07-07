<?php
namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    public function index()
    {
        $userLogin = Auth::user();

        // Jika admin: bisa kirim ke siapa pun
        $users = $userLogin->role === 'admin'
            ? User::where('id', '!=', $userLogin->id)->get()
            : User::where('role', 'admin')->get(); // warga hanya ke admin

        $pesans = Pesan::where(function ($query) {
                $query->where('pengirim_id', Auth::id())
                      ->orWhere('penerima_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('pesan.index', compact('users', 'pesans'));
    }

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

    public function fetchPesanBaru()
    {
        $pesans = Pesan::with('pengirim')
            ->where('penerima_id', Auth::id())
            ->where('is_read', false)
            ->orderBy('created_at', 'asc')
            ->get();

        // Tandai semua pesan sebagai sudah dibaca
        foreach ($pesans as $pesan) {
            $pesan->is_read = true;
            $pesan->save();
        }

        return response()->json($pesans);
    }
    public function hapusSemua()
{
    Pesan::where('penerima_id', Auth::id())->delete();
    return redirect()->back()->with('success', 'Semua pesan berhasil dihapus.');
}

}
