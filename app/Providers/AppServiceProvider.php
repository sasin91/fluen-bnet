<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Cache\Repository;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;
use Laravel\Socialite\SocialiteManager;
use Madewithlove\IlluminatePsrCacheBridge\Laravel\CacheItemPool;
use Psr\Cache\CacheItemPoolInterface;
use SocialiteProviders\BattleNet\Provider as BattleNetProvider;
use SocialiteProviders\BattleNet\Region;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $config = config('services.BattleNet', []);

        $this->app->bind('BattleNet.Region', function () use($config) {
            return new Region($config['region']);
        });

        $this->socialite()->extend('BattleNet', function ($app) use($config) {
            $config['redirect'] = secure_url($config['redirect']);

            return $this->socialite()->buildProvider(BattleNetProvider::class, $config)->region($app['BattleNet.Region']);
        });
    }

    /**
     * @return SocialiteManager
     */
    protected function socialite() : SocialiteManager
    {
        return $this->app->make(SocialiteFactory::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
        }
    }
}
