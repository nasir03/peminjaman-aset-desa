<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('warga', function ($user) {
            return $user->role === 'warga';
        });

        Gate::define('pimpinan', function ($user) {
            return $user->role === 'pimpinan';
        });
    }
}
