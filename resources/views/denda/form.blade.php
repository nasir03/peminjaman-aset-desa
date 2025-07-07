@extends('back-end.layouts.app')

@section('content')
<div class="container">
    <h3>Form Pembayaran Denda</h3>

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

    <p><strong>Nama Peminjam:</strong> {{ $pengembalian->peminjaman->user->name }}</p>
    <p><strong>Nama Aset:</strong> {{ $pengembalian->peminjaman->asset->nama_asset }}</p>
    <p><strong>Tanggal Pengembalian:</strong> {{ $pengembalian->tanggal_pengembalian }}</p>
    <p><strong>Denda Dikenakan:</strong> 
        <span class="text-danger">Rp {{ number_format(abs($pengembalian->denda), 0, ',', '.') }}</span>
    </p>

    {{-- Barcode Gambar --}}
    <div class="mb-4">
        <p><strong>Scan QR / Barcode:</strong></p>
        <img src="{{ asset('back-end/img/scan.jpg') }}" alt="Barcode" width="200">
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
            <label>Keterangan (Opsional)</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
        </div>

        <div class="form-group">
            <label>Upload Foto Pembayaran (jpg, jpeg, png, pdf)</label>
            <input type="file" name="foto_pembayaran" class="form-control-file" accept=".jpg,.jpeg,.png,.pdf" required>
            @error('foto_pembayaran')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Bayar Denda</button>
    </form>
</div>
@endsection
