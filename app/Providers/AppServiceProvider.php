<?php

namespace App\Providers;

use App\Models\Genre;
use App\Models\User;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use App\Providers\FilmServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->register(FilmServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        if(Schema::hasTable('genres'))
        {
            view()->share('genres', Genre::all());
            Paginator::useBootstrap();
        }
        Gate::define('manage_users', function(User $user){
            return $user->is_admin == 2;
        });
    }
}
