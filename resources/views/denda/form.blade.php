@extends('back-end.layouts.app')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #f8f9fc, #eef2f7);
    }

    .payment-container {
        background: #ffffff;
        padding: 35px 40px;
        border-radius: 18px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        margin-top: 30px;
        border: 1px solid #e6e6e6;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease-in-out;
    }

    .payment-container::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(120deg, rgba(255,215,0,0.15), rgba(78,115,223,0.12));
        transform: rotate(25deg);
        z-index: 0;
    }

    .payment-container h3 {
        font-weight: 700;
        margin-bottom: 25px;
        color: #2c3e50;
        position: relative;
        z-index: 1;
    }

    .payment-info {
        position: relative;
        z-index: 1;
    }

    .payment-info p {
        font-size: 16px;
        margin-bottom: 10px;
        color: #444;
    }

    .payment-info strong {
        color: #2c3e50;
        font-weight: 600;
    }

    .payment-info .text-danger {
        font-size: 18px;
        font-weight: 700;
        color: #e74a3b !important;
    }

    .barcode-box {
        background: #fafafa;
        padding: 20px;
        border-radius: 12px;
        display: inline-block;
        text-align: center;
        border: 1px dashed #ccc;
        transition: transform 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .barcode-box:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
        color: #2c3e50;
    }

    .form-control, .form-control-file, select {
        border-radius: 10px;
        box-shadow: none !important;
        border: 1px solid #dcdcdc;
        transition: all 0.2s;
    }

    .form-control:focus, select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.25rem rgba(78,115,223,.25);
    }

    .btn-primary, .btn-success {
        border-radius: 10px;
        padding: 12px 22px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s;
        box-shadow: 0 5px 12px rgba(0,0,0,0.15);
    }

    .btn-primary:hover, .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745, #218838);
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4e73df, #2e59d9);
        border: none;
    }

    .alert {
        border-radius: 10px;
    }

    .alert ul {
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
<div class="container payment-container">
    <h3>💳 Form Pembayaran Denda</h3>

    {{-- Tampilkan pesan error global jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan saat mengirim data:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Info Pengembalian --}}
    <div class="payment-info mb-3">
        <p><strong>Nama Peminjam:</strong> {{ $pengembalian->peminjaman->user->name }}</p>
        <p><strong>Nama Aset:</strong> {{ $pengembalian->peminjaman->asset->nama_asset }}</p>
        <p><strong>Tanggal Pengembalian:</strong> {{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d M Y') }}</p>
        <p><strong>Denda Dikenakan:</strong> 
            <span class="text-danger">Rp {{ number_format(abs($pengembalian->denda), 0, ',', '.') }}</span>
        </p>
    </div>

    {{-- Barcode Gambar --}}
    <div class="mb-4 barcode-box">
        <p><strong>Scan QR / Barcode:</strong></p>
        <img src="{{ asset('back-end/img/scan.jpg') }}" alt="Barcode" width="180">
        <br>
        <a href="{{ asset('back-end/img/scan.jpg') }}" download="barcode-denda.jpg" class="btn btn-sm btn-primary mt-2">
            Download Barcode
        </a>
    </div>

    {{-- Form Pembayaran --}}
    <form action="{{ route('denda.bayar', $pengembalian->id_pengembalian) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Jumlah Denda</label>
            <input type="number" name="jumlah_dibayar" value="{{ abs($pengembalian->denda) }}" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="">-- Pilih Metode --</option>
                <option value="Tunai">Tunai</option>
                <option value="Transfer">Transfer</option>
            </select>
            @error('metode_pembayaran')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Tanggal Bayar</label>
            <input type="date" name="tanggal_bayar" class="form-control" required>
            @error('tanggal_bayar')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Upload Bukti Pembayaran <small class="text-muted">(jpg, jpeg, png, pdf)</small></label>
            <input type="file" name="foto_pembayaran" class="form-control-file" accept=".jpg,.jpeg,.png,.pdf" required>
            @error('foto_pembayaran')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Bayar Denda</button>
    </form>
</div>
@endsection
