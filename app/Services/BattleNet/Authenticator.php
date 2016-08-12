<?php

namespace App\Services\BattleNet;


use App\Services\BattleNet\OAuth\AccessToken\Decorator;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Pwnraid\Bnet\OAuth;

/**
 * Class Authenticator
 * @package App\Services\BattleNet
 */
class Authenticator
{
    /**
     * @var Decorator
     */
    protected $token;

    /**
     * @var OAuth
     */
    protected $auth;

    /**
     * Authenticator constructor.
     *
     *
     * @param OAuth $auth
     */
    public function __construct(OAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Redirects to Battle.net for authorization.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect() : RedirectResponse
    {
        return redirect()->away(
            $this->auth->getAuthorizationUrl()
        );
    }

    /**
     * Handles the success callback from Battle.net
     *
     *
     * @param Request $request
     */
    public function handleCallback(Request $request)
    {
        $this->token = (new Decorator($this->auth))->from($request);

        return  $this;
    }

    /**
     * Returns a pre-populated User model instance.
     *
     *
     * @return User
     */
    public function user() : User
    {
        return (new User)->fill(
            $this->credentials()
        );
    }

    /**
     * Retrieves the User credentials from the ResourceOwner instance.
     *
     *
     * @return array
     */
    public function credentials() : array
    {
        return $this->token->credentials();
    }
}