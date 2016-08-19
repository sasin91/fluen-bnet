<?php

namespace App\Http\Controllers;

use App\Services\BattleNet\Facades\BattleNet;
use League\OAuth2\Client\Token\AccessToken;
use Pwnraid\Bnet\Core\AbstractClient;
use Pwnraid\Bnet\Diablo\Client as DiabloClient;
use Pwnraid\Bnet\Starcraft\Client as StarcraftClient;
use Pwnraid\Bnet\Warcraft\Client as WarcraftClient;

/**
 * Class BattleNetController
 * @package App\Http\Controllers
 */
class BattleNetController extends Controller
{
    /**
     * Retrieves a WarcraftClient instance.
     *
     *
     * @return WarcraftClient
     */
    protected function WoWClient() : WarcraftClient
    {
        return $this->client(WarcraftClient::class);
    }

    /**
     * Retrieves a StartCraft 2 Client.
     * 
     * 
     * @return StarcraftClient
     */
    protected function StarcraftClient() : StarcraftClient
    {
        return $this->client(StarcraftClient::class);
    }

    /**
     * Retrieves a Diablo 3 Client.
     * 
     * 
     * @return DiabloClient
     */
    protected function DiabloClient() : DiabloClient
    {
        return $this->client(DiabloClient::class);
    }

    /**
     * Retrieves a BattleNet client. 
     * 
     * 
     * @param string $client
     * @return AbstractClient
     */
    protected function client(string $client) : AbstractClient
    {
        return BattleNet::client($client);
    }

    /**
     * Retrieves our AccessToken instance.
     *
     *
     *
     * @return AccessToken
     */
    protected function AccessToken() : AccessToken
    {
        return BattleNet::auth()->accessToken();
    }
}
