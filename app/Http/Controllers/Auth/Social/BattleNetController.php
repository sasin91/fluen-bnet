<?php

namespace App\Http\Controllers\Auth\Social;

use App\Http\Controllers\Auth\SocialController;
use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class BattleNetController extends SocialController
{
    /**
     * The Socialite providers name
     *
     * @var string
     */
    protected $provider = 'BattleNet';

    /**
     * Handles the success callback from Battle.net
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(Request $request)
    {
        $this->guard->login(
            $this->lookupOrCreateUserFrom(
                $this->socialite->user()
            )
        );

        $request->session()->regenerate();

        return redirect()->intended('/home');
    }

    /**
     * Redirects to Battle.net for Authentication.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider()
    {
        return $this->socialite->redirect();
    }

    /**
     * Retrieves the access_token of the current user.
     *
     * @return string
     */
    public function getProviderToken()
    {
        return session()->get('Socialite.BattleNet.AccessToken');
    }
    
    /**
     * Looks up or creates a User.
     *
     * @param SocialiteUser $user
     * @return Authenticatable
     */
    protected function lookupOrCreateUserFrom(SocialiteUser $user)
    {
        session()->put('Socialite.BattleNet.AccessToken', $user->token);

        return User::firstOrCreate([
            'uid'       =>  $user->getId(),
            'battleTag' =>  $user->getNickname()
        ]);
    }

}
