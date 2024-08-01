<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('isUser', function($users) {
            return $users->role_id == 1;
        });

        Gate::define('isAdmin', function($users) {
            return $users->role_id == 2;
        });
    }
}
