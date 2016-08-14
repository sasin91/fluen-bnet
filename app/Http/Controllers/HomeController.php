<?php

namespace App\Http\Controllers;

use App\Services\BattleNet\Facades\BattleNet;
use Illuminate\Http\Request;
use League\OAuth2\Client\Token\AccessToken;
use Pwnraid\Bnet\Warcraft\Client as WarcraftClient;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = $this->WoWClient();
        $characters = $client->characters()->user($this->AccessToken());

        return view('home', compact('characters'));
    }

    /**
     * Retrieves our WarcraftClient instance.
     *
     *
     * @return WarcraftClient
     */
    private function WoWClient() : WarcraftClient
    {
        return BattleNet::client(WarcraftClient::API);
    }

    /**
     * Retrieves our AccessToken instance.
     *
     *
     *
     * @return AccessToken
     */
    private function AccessToken() : AccessToken
    {
        return BattleNet::auth()->accessToken();
    }
}
