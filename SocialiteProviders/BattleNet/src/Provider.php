<?php

namespace SocialiteProviders\BattleNet;

use Laravel\Socialite\Two\ProviderInterface;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider implements ProviderInterface
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'BATTLENET';

    /**
     * {@inheritdoc}
     */
    protected $scopes = ['wow.profile'];

    /**
     * @var Region
     */
    protected $region;

    /**
     * @param Region $region
     * @return $this
     */
    public function region(Region $region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase($this->region->oAuthUrl('authorize'), $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return $this->region->oAuthUrl('token');
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get($this->region->apiUrl("account/user?access_token=$token"), [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        $user = json_decode($response->getBody(), true);

        $characters = $this->getHttpClient()->get($this->region->apiUrl("wow/user/characters?access_token=$token"), [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ])->getBody();

        $user['characters'] = array_first(json_decode($characters, true));

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'       => $user['id'],
            'nickname' => $user['battletag'],
            'characters' => $user['characters']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code'
        ]);
    }
}
