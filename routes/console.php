<?php

use Illuminate\Support\Facades\Schedule;
use App\Http\Controllers\NotifikasiController;

Schedule::call(function () {
    app(\App\Http\Controllers\NotifikasiController::class)->pengingatDanTerlambatPengembalian();
})->everyMinute(); // << Ubah jadi setiap menit

