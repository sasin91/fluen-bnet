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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::get('/auth/battleNet', [
            'as' => config('services.bnet.redirectUri', env('BATTLENET_API_REDIRECT')),
            'uses' => config('services.bnet.controller', env('BATTLENET_API_CONTROLLER', 'Auth\RegisterController@redirectToBattleNet'))
        ]);

        Route::get('/auth/battleNet/callback', [
            'as' => config('services.bnet.callbackUri', env('BATTLENET_API_CALLBACK')),
            'uses' => config('services.bnet.controller',env('BATTLENET_API_CONTROLLER', 'Auth\RegisterController@handleBattleNetCallback'))
        ]);
    }

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
                new Region(config('services.bnet.region'), Region::EUROPE)
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
