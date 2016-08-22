<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Cache\Repository;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;
use Laravel\Socialite\SocialiteManager;
use Madewithlove\IlluminatePsrCacheBridge\Laravel\CacheItemPool;
use Psr\Cache\CacheItemPoolInterface;
use SocialiteProviders\BattleNet\Provider as BattleNetProvider;

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

        $socialite = $this->socialite();
        $socialite->extend('BattleNet', function ($app) use($socialite) {
            $config = config('services.BattleNet', []);
            $config['redirect'] = secure_url($config['redirect']);
            return $socialite->buildProvider(BattleNetProvider::class, $config);
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
