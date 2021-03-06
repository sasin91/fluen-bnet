<?php

namespace App\Http\Controllers\Auth\Social;

use App\BattleNet\Character;
use App\BattleNet\CharacterSpec;
use App\Http\Controllers\Auth\SocialController;
use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class BattleNetController extends SocialController
{
    /**
     * The Socialite providers name
     *
     * @var string
     */
    protected $provider = 'BattleNet';

    /**
     * Handles the success callback from Battle.net
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(Request $request)
    {
        $this->guard->login(
            $this->lookupOrCreateUserFrom(
                $this->socialite->user()
            )
        );

        $request->session()->regenerate();

        return redirect()->home();
    }

    /**
     * Redirects to Battle.net for Authentication.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider()
    {
        return $this->socialite->redirect();
    }

    /**
     * Looks up or creates a User.
     *
     * @param SocialiteUser $user
     * @return Authenticatable
     */
    protected function lookupOrCreateUserFrom(SocialiteUser $abstractUser)
    {
        $user = User::firstOrFail([
            'uid'       =>  $abstractUser->getId(),
            'battleTag' =>  $abstractUser->getNickname()
        ]);

        if (array_key_exists('characters', (array)$abstractUser))
        {
            $user->characters()->saveMany(
                collect($abstractUser['characters'])->transform(function (array $attributes) {
                    if (array_key_exists('lastModified', $attributes))
                    {
                        // remove the last three 0's by dividing by a thousand..
                        // this is due to Blizzards API returning in ms since unix epoch.
                        // @ref: http://pubs.opengroup.org/onlinepubs/9699919799/basedefs/V1_chap04.html#tag_04_15
                        $attributes['lastModified'] = $attributes['lastModified'] / 1000;

                        // If it's a fresh character,
                        // then just unset the lastModified date.
                        if ($attributes['lastModified'] <= 0)
                        {
                            unset($attributes['lastModified']);
                        }
                    }

                    $character = Character::create($attributes);

                    if (array_key_exists('spec', $attributes))
                    {
                        $character->spec()->save(CharacterSpec::firstOrNew($attributes['spec']));
                    }

                    return $character;
                })
            );
        }

        return $user;
    }

}
