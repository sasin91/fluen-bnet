<?php

namespace App\Services\BattleNet\Traits;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\BattleNet\Facades\BattleNet;
use Illuminate\Support\Collection;

/**
 * Class BattleNetControllerTrait
 * @package App\Services\BattleNet
 */
trait BattleNetControllerTrait
{
    /**
     * Redirects to Battle.net for Authentication.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToBattleNet()
    {
        return BattleNet::auth()->redirect();
    }

    /**
     * Handles the success callback from Battle.net
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleBattleNetCallback(Request $request) : RedirectResponse
    {
        $details = BattleNet::auth()->handleCallback($request)->details();
        $user = $this->lookupUser($details) ?: new User($details);

        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }

    /**
     * Looks up a User, if any.
     *
     *
     * @param Collection $details
     * @return mixed
     */
    private function lookupUser(Collection $details) : mixed
    {
        return User::where('uid', $details->get('uid'))
            ->orWhere('battleTag', $details->get('battleTag'))
            ->first();
    }
}