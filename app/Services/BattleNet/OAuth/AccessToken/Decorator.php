<?php

namespace App\Services\BattleNet\OAuth\AccessToken;


use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Pwnraid\Bnet\OAuth;

/**
 * Class Decorator
 * @package App\Services\BattleNet\OAuth\AccessToken
 */
class Decorator
{
    /**
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * @var OAuth
     */
    protected $OAuth;

    /**
     * Decorator constructor.
     *
     *
     * @param OAuth $OAuth
     */
    public function __construct(OAuth $OAuth)
    {
        $this->OAuth = $OAuth;
    }

    /**
     * Retrieves the AccessToken from given Request.
     *
     *
     * @param Request $request
     * @return Decorator
     */
    public function from(Request $request) : Decorator
    {
        $this->accessToken = $this->OAuth->getAccessToken('authorization_code', [
            'code' => $request->code
        ]);

        return $this;
    }

    /**
     * Returns the raw AccessToken
     *
     *
     * @return AccessToken
     */
    public function accessToken() : AccessToken
    {
        return $this->accessToken;
    }

    /**
     * Checks if this token has expired.
     *
     *
     * @return bool
     */
    public function expired() : bool
    {
        return $this->accessToken->hasExpired();
    }

    /**
     * Refreshes the AccessToken
     *
     *
     * @return $this
     */
    public function refresh() : Decorator
    {
        $this->accessToken = $this->OAuth->getAccessToken('refresh_token', [
            'refresh_token' => $this->accessToken->getRefreshToken()
        ]);

        return $this;
    }

    /**
     * Grabs the resource owner details
     *
     *
     * @return array
     */
    public function credentials() : array
    {
        return $this->resourceOwner()->toArray();
    }

    /**
     * Returns the ResourceOwner instance
     *
     *
     * @return ResourceOwnerInterface
     */
    public function resourceOwner() : ResourceOwnerInterface
    {
        return $this->OAuth->getResourceOwner(
            $this->accessToken
        );
    }

}