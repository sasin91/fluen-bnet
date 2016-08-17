<?php

namespace App\Services\BattleNet\Traits;
use Illuminate\Support\Facades\Route;

/**
 * This trait is intended to imported in your RouteServiceProvider.
 *
 *
 * Class BattleNetRouteServiceProviderTrait
 * @package App\Services\BattleNet\Traits
 */
trait BattleNetRouteServiceProviderTrait
{
    /**
     * Define the battleNet auth routes.
     *
     * These routes will handle the authorization with battle.net.
     *
     *
     * @return void
     */
    protected function mapBattleNetRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function () {
            Route::get('/auth/battleNet', [
                'as' => config('services.bnet.redirectUri', env('BATTLENET_API_REDIRECT')),
                'uses' => config('services.bnet.controller', env('BATTLENET_API_CONTROLLER', 'Auth\RegisterController@redirectToBattleNet'))
            ]);

            Route::get('/auth/battleNet/callback', [
                'as' => config('services.bnet.callbackUri', env('BATTLENET_API_CALLBACK')),
                'uses' => config('services.bnet.controller',env('BATTLENET_API_CONTROLLER', 'Auth\RegisterController@handleBattleNetCallback'))
            ]);
        });
    }
}