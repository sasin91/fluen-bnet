<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Contracts\Config\Repository as Config;

class BattleNetTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();
    }

    public function test_a_user_can_signUp_with_BattleNet_through_Socialite()
    {
        $provider = Mockery::mock(Laravel\Socialite\Contracts\Provider::class);
        $provider->shouldReceive('redirect')->andReturn('Redirected');

        $provider = Mockery::mock(Laravel\Socialite\Contracts\Provider::class);
        $provider->shouldReceive('user')->andReturn($this->user());

        Socialite::shouldReceive('driver')->with('BattleNet')->andReturn($provider);

        // After Oauth redirect back to the route
        $this->visit('/auth/battleNet/callback')->seePageIs('/home');
    }

    /**
     * @return \Laravel\Socialite\Contracts\User
     */
    protected function user()
    {
        $faker = $this->faker();

        $abstract = Mockery::mock(Laravel\Socialite\Two\User::class)->makePartial();
        $abstract->shouldReceive('getId')
            ->andReturn($faker->numberBetween())
            ->shouldReceive('getNickname')
            ->andReturn($faker->name.'#'.$faker->numberBetween(1, 5000));

        return $abstract;
    }

    /**
     * @return \Faker\Generator
     */
    protected function faker()
    {
        return $this->app->make(\Faker\Generator::class);
    }
}
