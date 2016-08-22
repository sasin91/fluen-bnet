<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\SocialiteManager;

/**
 * Class SocialController
 * @package App\Http\Controllers\Auth
 */
abstract class SocialController extends Controller
{
    /**
     * The Socialite providers name
     *
     * @var string
     */
    protected $provider;

    /**
     * @var SocialiteManager
     */
    protected $socialite;

    /**
     * @var StatefulGuard
     */
    protected $guard;

    /**
     * SocialController constructor.
     *
     *
     * @param SocialiteManager $socialite
     * @param StatefulGuard $guard
     */
    public function __construct(Factory $socialite, Guard $guard)
    {
        $this->socialite = $this->provider ? $socialite->driver($this->provider) : $socialite->getDefaultDriver();
        $this->guard = $guard;
    }

    /**
     * Redirects to the provider for Authentication.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public abstract function redirectToProvider();

    /**
     * Handles the success callback from the provider.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public abstract function handleProviderCallback(Request $request);

    /**
     * Looks up a User.
     *
     * @param array $details
     * @return null|User
     */
    protected abstract function lookupOrCreateUserFrom(SocialiteUser $user);

}
