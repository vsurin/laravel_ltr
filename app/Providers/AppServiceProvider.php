<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::before(function ($user) {
            if ($user->role == 'admin') {
                return true;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function() {
            return base_path().'/public_html';
        });
    }
}
