<?php

namespace App\Http\Controllers;

use App\Services\BattleNet\Facades\BattleNet;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use League\OAuth2\Client\Token\AccessToken;
use Pwnraid\Bnet\Warcraft\Client as WarcraftClient;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() : View
    {
        return view('home', ['user' => Auth::user()]);
    }

    public function profile() : View
    {
        $client = $this->WoWClient();
        $characters = $client->characters()->user($this->AccessToken());

        // @TODO: Profile

        return view('home.characters', compact('characters'));
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
