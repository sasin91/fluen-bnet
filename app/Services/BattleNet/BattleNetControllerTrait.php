<?php

namespace App\Services\BattleNet;
use Illuminate\Http\Request;
use App\Services\BattleNet\Facades\BattleNet;

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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleBattleNetCallback(Request $request)
    {
        $user = BattleNet::auth()->handleCallback($request)->credentials();

        $this->validator($user);

        $this->guard()->login(
            $this->create($user)
        );

        return redirect($this->redirectPath());
    }
}