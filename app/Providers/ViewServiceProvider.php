<?php

namespace App\Providers;

use App\GuestUser;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('user', auth()->user() ?: new GuestUser);
    }
}
