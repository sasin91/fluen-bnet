<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Cache\Repository;
use Madewithlove\IlluminatePsrCacheBridge\Laravel\CacheItemPool;
use Psr\Cache\CacheItemPoolInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(CacheItemPoolInterface::class, function () {
            $repository = $this->app->make(Repository::class);

            return new CacheItemPool($repository);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
