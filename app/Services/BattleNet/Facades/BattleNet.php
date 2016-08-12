<?php

namespace App\Services\BattleNet\Facades;

use App\Services\BattleNet\Contract;
use App\Services\BattleNet\Authenticator;
use Pwnraid\Bnet\Core\AbstractClient;
use Illuminate\Support\Facades\Facade as IlluminateFacade;

/**
 * Class Facade
 * @package app\Services\BattleNet
 *
 *
 * @method static Authenticator auth()
 * @method static AbstractClient client(string $client)
 */
class BattleNet extends IlluminateFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() : string
    {
        return Contract::class;
    }
}