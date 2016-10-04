<?php

use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\BattleNet\Character::class)->times(5)->create()->each(function (\App\BattleNet\Character $character) {
            $character->spec()->save(factory(\App\BattleNet\CharacterSpec::class)->make());
        });
    }
}
