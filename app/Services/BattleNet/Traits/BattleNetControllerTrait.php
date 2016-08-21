<?php

namespace App\Services\BattleNet\Traits;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as FoundationUser;
use App\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Services\BattleNet\Facades\BattleNet;

use Illuminate\Notifications\Notifiable;
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
        $user = $this->lookupUser($details) ?: $this->createUser($details);

        $this->guard()->login($user);
        $request->session()->regenerate();

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Looks up a User.
     *
     *
     * @param Collection $details
     * @return mixed|null
     */
    private function lookupUser(Collection $details)
    {
        return $this->user()->where('uid', $details->get('uid'))
            ->orWhere('battleTag', $details->get('battleTag'))
            ->first();
    }

    private function createUser(Collection $details)
    {
        $details->wasCreatedWithBattleNet = true;
        return $this->user()->create($details->toArray());
    }

    /**
     * returns App\User if available
     * else resorts to Foundation\Auth\User
     *
     *
     * @return FoundationUser|Model|Notifiable|Authenticatable
     */
    private function user() : Authenticatable
    {
        $model = config('services.bnet.model', FoundationUser::class);
        return new $model;
    }
}