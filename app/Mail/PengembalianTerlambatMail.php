<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengembalianTerlambatMail extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman;
    public $pesan;

    public function __construct($peminjaman, $pesan)
    {
        $this->peminjaman = $peminjaman;
        $this->pesan = $pesan;
    }

    public function build()
    {
        return $this->subject('Notifikasi Aset Desa')
                    ->view('emails.pengembalian_terlambat');
    }
}
