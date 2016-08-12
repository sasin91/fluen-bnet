<?php

namespace App\Services\BattleNet;


use Pwnraid\Bnet\ClientFactory;
use Pwnraid\Bnet\Core\AbstractClient;
use Pwnraid\Bnet\OAuth;
use Pwnraid\Bnet\Region;

/**
 * Class BattleNet
 * @package App\Services\BattleNet
 */
class BattleNet implements Contract
{
    /**
     * @var Region
     */
    protected $region;

    /**
     * @var ClientFactory
     */
    protected $clientFactory;

    /**
     * BattleNet constructor.
     *
     *
     * @param ClientFactory $clientFactory
     * @param Region $region
     */
    public function __construct(ClientFactory $clientFactory, Region $region)
    {
        $this->region = $region;
        $this->clientFactory = $clientFactory;
    }

    /**
     * Returns a battle.net client
     *
     *
     * @throws \InvalidArgumentException
     * @param string $client
     * @return AbstractClient
     */
    public function client(string $client) : AbstractClient
    {
        if (!method_exists($this->clientFactory, $client))
        {
            if (class_exists($client) && is_subclass_of($client, AbstractClient::class))
            {
                return $this->client((new \ReflectionClass($client))->getShortName());
            }

            throw new \InvalidArgumentException("$client is not valid.");
        }

        return $this->clientFactory->{$client($this->region)};
    }

    /**
     * Returns a League OAuth2 client
     * configured for battle.net
     *
     *
     * @param array $options
     * @return Authenticator
     */
    public function auth(array $options = []) : Authenticator
    {
        return new Authenticator(
            new OAuth($this->region, $options)
        );
    }
}