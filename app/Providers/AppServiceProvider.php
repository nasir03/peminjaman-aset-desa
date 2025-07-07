<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesan;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Kirim variabel $pesans ke topbar
        View::composer('back-end.partials.topbar', function ($view) {
            if (Auth::check()) {
                $pesans = Pesan::where('penerima_id', Auth::id())
                              ->latest()
                              ->take(5)
                              ->get();
                $view->with('pesans', $pesans);
            }
        });
    }
}
