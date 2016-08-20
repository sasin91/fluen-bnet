<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 12-08-16
 * Time: 22:47
 */
namespace App\Services\BattleNet;

use Pwnraid\Bnet\Core\AbstractClient;
use Pwnraid\Bnet\Region;


/**
 * Class BattleNet
 * @package App\Services\BattleNet
 */
interface Contract
{
    /**
     * Returns a battle.net client
     *
     *
     * @throws \InvalidArgumentException
     * @param string $client
     * @return AbstractClient
     */
    public function client($client) : AbstractClient;

    /**
     * Returns a League OAuth2 client
     * configured for battle.net
     *
     *
     * @return Authenticator
     */
    public function auth() : Authenticator;

    /**
     * Returns the current Region
     *
     *
     * @return Region
     */
    public function region() : Region;
}