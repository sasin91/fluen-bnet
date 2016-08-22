<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Foundation\Testing\Concerns\InteractsWithPages;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Support\Facades\Auth;
use App\Services\BattleNet\Facades\BattleNet;
use Faker\Generator;
use League\OAuth2\Client\Token\AccessToken;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use App\Services\BattleNet\OAuth\AccessToken\Decorator;

class BattleNetTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, InteractsWithDatabase, InteractsWithAuthentication, InteractsWithPages;

    protected $credentials;

    protected function credentials()
    {
        $faker = $this->getFaker();

        return $this->credentials ?: $this->credentials = [
            'uid'         =>  $faker->randomNumber(),
            'battleTag'   =>  $faker->word,
            'name'        =>  $faker->name,
            'email'       =>  $faker->email,
            'password'    =>  $faker->password
        ];
    }

    /**
     * @return Generator
     */
    protected function getFaker() : Generator
    {
        return app(Generator::class);
    }

    public function testCanAuthenticateAgainstBattleNet()
    {
        $credentials = collect($this->credentials());

        BattleNet::shouldReceive('auth->handleCallback')->andReturn(
            Mockery::mock(Decorator::class)
                ->shouldReceive('details')
                ->andReturn($credentials)
        )->once();

        BattleNet::shouldReceive('auth->details')->andReturn($credentials);

        BattleNet::makePartial();

        $this->visitRoute('bnet::auth::callback');

        $this->seeIsAuthenticated();
    }
}
