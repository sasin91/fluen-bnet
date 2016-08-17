<?php

namespace App\Services\BattleNet;

use Illuminate\Support\ServiceProvider;
use Psr\Cache\CacheItemPoolInterface;
use Pwnraid\Bnet\ClientFactory;
use Pwnraid\Bnet\Region;

/**
 * Class BattleNetServiceProvider
 * @package App\Services\BattleNet
 */
class BattleNetServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Contract::class, function ($app) {
            return new BattleNet(
                new ClientFactory(config('services.bnet.key', env('BATTLENET_API_KEY')), $app[CacheItemPoolInterface::class]),
                new Region(config('services.bnet.region', Region::EUROPE))
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() : array
    {
        return [
            Contract::class
        ];
    }
}