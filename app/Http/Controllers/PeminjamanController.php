<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Asset;
use App\Models\Notifikasi;
use App\Models\Peminjaman;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function create()
    {
        $users = User::all();
        $assets = Asset::all();
        return view('peminjaman.form', compact('users', 'assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user'              => 'required|exists:users,id',
            'id_asset'             => 'required|exists:asset,id_asset',
            'tanggal_pinjam'       => 'required|date',
            'tanggal_kembali'      => 'required|date|after_or_equal:tanggal_pinjam',
            'keperluan_peminjaman' => 'required|string|max:255',
            'foto_ktp'             => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoKtpPath = $request->file('foto_ktp')?->store('foto_ktp', 'public');

        $idPeminjamanBaru = DB::table('peminjaman')->insertGetId([
            'id_user'              => $request->id_user,
            'id_asset'             => $request->id_asset,
            'tanggal_pinjam'       => $request->tanggal_pinjam,
            'tanggal_kembali'      => $request->tanggal_kembali,
            'keperluan_peminjaman' => $request->keperluan_peminjaman,
            'catatan_admin'        => $request->catatan_admin,
            'jumlah_pinjam'        => $request->jumlah_pinjam,
            'status'               => 'pending',
            'foto_ktp'             => $fotoKtpPath,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        $adminUsers = User::where('role', 'admin')->get();
        foreach ($adminUsers as $admin) {
            Notifikasi::create([
                'id_user'       => $request->id_user,
                'penerima_id'   => $admin->id,
                'id_peminjaman' => $idPeminjamanBaru,
                'pesan'         => User::find($request->id_user)->name . ' mengajukan peminjaman aset. Silakan setujui atau tolak.',
                'dibaca'        => false,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan.');
    }

    public function index()
    {
        $peminjaman = DB::table('peminjaman')
            ->join('users', 'peminjaman.id_user', '=', 'users.id')
            ->join('asset', 'peminjaman.id_asset', '=', 'asset.id_asset')
            ->select(
                'peminjaman.*',
                'users.name as nama_user',
                'users.no_telepon',
                'users.jenis_kelamin',
                'users.alamat as alamat_user',
                'asset.nama_asset'
            )
            ->orderByDesc('peminjaman.id_peminjaman')
            ->get();

        $notifikasiPeminjaman = DB::table('notifications')
            ->where('penerima_id', Auth::id())
            ->where('dibaca', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('peminjaman.index', compact('peminjaman', 'notifikasiPeminjaman'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        DB::table('peminjaman')->where('id_peminjaman', $id)->update([
            'status' => $request->status,
            'updated_at' => now()
        ]);

        $peminjaman = DB::table('peminjaman')->where('id_peminjaman', $id)->first();

        $pesan = "Peminjaman aset Anda telah " . ($request->status === 'disetujui' ? 'disetujui' : 'ditolak') . " oleh admin.";
        Notifikasi::create([
            'id_user' => Auth::id(),
            'penerima_id' => $peminjaman->id_user,
            'id_peminjaman' => $id,
            'pesan' => $pesan,
            'dibaca' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Status berhasil diperbarui.');
    }

    public function cekNotifikasi()
    {
        $notifTerbaru = DB::table('notifications')
            ->where('penerima_id', Auth::id())
            ->where('dibaca', false)
            ->latest('id')
            ->first();

        return response()->json([
            'latest_id' => $notifTerbaru?->id,
            'pesan' => $notifTerbaru?->pesan,
            'created_at' => $notifTerbaru?->created_at,
        ]);
    }

    public function destroy($id)
    {
        DB::table('peminjaman')->where('id_peminjaman', $id)->delete();
        DB::table('notifications')->where('id_peminjaman', $id)->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function edit($id)
    {
        $data = Peminjaman::findOrFail($id);
        $users = User::all();
        $assets = Asset::all();

        return view('peminjaman.edit', compact('data', 'users', 'assets'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_asset' => 'required|exists:asset,id_asset',
            'jumlah_pinjam' => 'required|integer',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'keperluan_peminjaman' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'alamat' => 'required|string|max:255',
        ]);

        DB::table('peminjaman')->where('id_peminjaman', $id)->update([
            'id_user' => $request->id_user,
            'id_asset' => $request->id_asset,
            'jumlah_pinjam' => $request->jumlah_pinjam,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'keperluan_peminjaman' => $request->keperluan_peminjaman,
            'updated_at' => now(),
        ]);

        DB::table('users')->where('id', $request->id_user)->update([
            'no_telepon' => $request->no_telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'updated_at' => now(),
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil diperbarui.');
    }

    // Fitur baru: proses pengembalian + notifikasi denda
    public function prosesPengembalian(Request $request, $id)
    {
        $request->validate([
            'status_pengembalian' => 'required|in:tepat waktu,terlambat,rusak ringan,rusak berat,hilang'
        ]);

        DB::table('peminjaman')->where('id_peminjaman', $id)->update([
            'status_pengembalian' => $request->status_pengembalian,
            'updated_at' => now(),
        ]);

        $peminjaman = DB::table('peminjaman')->where('id_peminjaman', $id)->first();
        $user = User::find($peminjaman->id_user);
        $adminUsers = User::where('role', 'admin')->get();

        $pesanDenda = match ($request->status_pengembalian) {
            'terlambat' => "Anda terlambat mengembalikan aset dan terkena denda.",
            'rusak ringan' => "Aset yang Anda kembalikan mengalami kerusakan ringan. Anda dikenakan denda.",
            'rusak berat' => "Aset yang Anda kembalikan mengalami kerusakan berat. Anda dikenakan denda.",
            'hilang' => "Aset yang Anda pinjam dinyatakan hilang. Anda terkena denda penuh.",
            default => null,
        };

        if ($pesanDenda) {
    $namaAsset = DB::table('asset')->where('id_asset', $peminjaman->id_asset)->value('nama_asset');
    $tanggalPinjam = Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y');

    // Notifikasi untuk warga
    $pesanWarga = "Anda dikenakan denda karena {$request->status_pengembalian} aset <strong>{$namaAsset}</strong> yang dipinjam pada {$tanggalPinjam}.";

    Notifikasi::create([
        'id_user' => Auth::id(),
        'penerima_id' => $peminjaman->id_user,
        'id_peminjaman' => $id,
        'pesan' => strip_tags($pesanWarga),
        'tipe' => 'denda',
        'dibaca' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Notifikasi untuk admin
    foreach ($adminUsers as $admin) {
        $pesanAdmin = "Peminjaman ID #$id dikenakan denda: <strong>{$request->status_pengembalian}</strong> oleh <strong>{$user->name}</strong>.";

        Notifikasi::create([
            'id_user' => Auth::id(),
            'penerima_id' => $admin->id,
            'id_peminjaman' => $id,
            'pesan' => strip_tags($pesanAdmin),
            'tipe' => 'denda',
            'dibaca' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

        return redirect()->route('peminjaman.index')->with('success', 'Pengembalian diproses & notifikasi dikirim.');
    }
}
