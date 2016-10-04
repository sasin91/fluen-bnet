<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;

class BattleNetTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, InteractsWithDatabase, InteractsWithAuthentication;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();
    }

    public function test_a_user_can_signUp_with_BattleNet_through_Socialite()
    {
        $provider = Mockery::mock(Laravel\Socialite\Contracts\Provider::class)->makePartial();
        $provider->shouldReceive('redirect')->andReturn('Redirected');
        $provider->shouldReceive('user')->andReturn($this->user());

        Socialite::shouldReceive('driver')->with('BattleNet')->andReturn($provider);

        // After Oauth redirect back to the route
        $this->visit('/auth/battleNet/callback')->seePageIs('/home');

        $this->seeIsAuthenticated();

        $this->visitRoute('home')->dontSee(trans('home.characters.none'));
    }

    /**
     * @return \Laravel\Socialite\Contracts\User
     */
    protected function user()
    {
        $faker = $this->app->make(\Faker\Generator::class);

        $abstract = Mockery::mock(Laravel\Socialite\Two\User::class)->makePartial();
        $abstract->shouldReceive('getId')->andReturn($faker->numberBetween());
        $abstract->shouldReceive('getNickname')->andReturn($faker->name.'#'.$faker->numberBetween(1, 5000));
        $abstract->shouldReceive('offsetGet')->with('characters')->andReturn($this->characters());

        return $abstract;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function characters()
    {
        $this->seed(CharacterSeeder::class);
        return \App\BattleNet\Character::all();
    }
}
