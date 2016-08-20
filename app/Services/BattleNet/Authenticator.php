<?php

namespace App\Services\BattleNet;


use App\Services\BattleNet\OAuth\AccessToken\Decorator;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use League\OAuth2\Client\Token\AccessToken;
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
        $this->token = new Decorator($auth);
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
     * @return Authenticator
     */
    public function handleCallback(Request $request)
    {
        $this->token->from($request);

        return $this;
    }

    /**
     * @return OAuth
     */
    public function OAuth() : OAuth
    {
        return $this->auth;
    }

    /**
     * Retrieves the raw AccessToken instance from our Decorator instance.
     *
     *
     * @return AccessToken
     */
    public function accessToken() : AccessToken
    {
        return $this->token->accessToken();
    }

    /**
     * Retrieves the User details from the ResourceOwner instance.
     *
     *
     * @return Collection
     */
    public function details() : Collection
    {
        return $this->token->details();
    }
}