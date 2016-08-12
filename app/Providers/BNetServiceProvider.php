<?php

namespace App\Providers;

use App\Services\BattleNet\BattleNet;
use App\Services\BattleNet\Facades\BattleNet as Facade;
use App\Services\BattleNet\Contract;
use Illuminate\Support\ServiceProvider;
use Psr\Cache\CacheItemPoolInterface;
use Pwnraid\Bnet\ClientFactory;
use Pwnraid\Bnet\Region;

/**
 * Class BNetServiceProvider
 * @package App\Providers
 */
class BNetServiceProvider extends ServiceProvider
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
                new ClientFactory(config('services.bnet.key'), $app[CacheItemPoolInterface::class]),
                new Region(config('services.bnet.region'))
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Contract::class
        ];
    }
}
