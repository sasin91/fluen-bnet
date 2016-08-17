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
    public function client($client) : AbstractClient
    {
        if (!$this->inFactory($client))
        {
            if (class_exists($client) && is_subclass_of($client, AbstractClient::class))
            {
               return $this->client(
                    $this->clientToMethod($client)
               );
            }
            throw new \InvalidArgumentException("$client is not valid.");
        }

        return $this->build($client);
    }

    /**
     * Returns a League OAuth2 client
     * configured for battle.net
     *
     *
     * @return Authenticator
     */
    public function auth() : Authenticator
    {
        return new Authenticator(
            new OAuth($this->region, $this->authOptions())
        );
    }

    /**
     * Returns the auth options.
     *
     * @return array
     */
    protected function authOptions() : array
    {
        return [
            'clientId'      =>  config('services.bnet.key'),
            'clientSecret'  =>  config('services.bnet.secret'),
            'redirectUri'   =>  route('bnet::auth::callback')
        ];
    }

    /**
     * Attempts to deduce a Factory method associated with the given Client.
     *
     *
     * @param $client
     * @return string
     */
    private function clientToMethod($client) : string
    {
        $reflection = new \ReflectionClass($client);

        $candidate = null;

        if ($reflection->hasConstant('API'))
        {
            $candidate = $reflection->getConstant('API');
        } else {
            $candidate = last(
                explode('\\', $reflection->getNamespaceName())
            );
        }

        return $this->client($candidate);
    }

    /**
     * Calls the corresponding method to the client.
     * This assumes that method exists.
     *
     *
     * @param string $client
     * @return AbstractClient
     */
    private function build(string $client) : AbstractClient
    {
        return $this->clientFactory->$client($this->region);
    }

    /**
     * Checks whether the requested candidate exists in Factory.
     *
     *
     * @param string $candidate
     * @return bool
     */
    private function inFactory(string $candidate) : bool
    {
        return method_exists($this->clientFactory, $candidate);
    }
}