<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Pengembalian Aset</title>
</head>
<body style="font-family: sans-serif;">
    <h2>Pengingat Pengembalian Aset</h2>

    <p>Halo {{ $peminjaman->user->name }},</p>

    <p>{!! $pesan !!}</p>

    <p>Mohon segera mengembalikan aset ke kantor desa agar tidak terkena sanksi atau denda.</p>

    <p>Terima kasih,<br>
    Sistem Peminjaman Aset Desa</p>
</body>
</html>
