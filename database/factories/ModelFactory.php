
<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\BattleNet\Character::class, function (Faker\Generator $faker) {
    $character = new \App\BattleNet\Character;
    return [
        'name'  =>  $faker->name,
        'realm' =>  $faker->word,
        'battlegroup' => $faker->word,
        'class' =>  array_rand($character->classes(), 1),
        'race'  =>  array_rand($character->races(), 1),
        'gender'    =>  array_rand($character->genders(), 1),
        'level' =>  $faker->numberBetween(1, 110),
        'achievementPoints' =>  $faker->numberBetween(),
        'thumbnail' =>  $faker->imageUrl(),
        "guild" =>  $faker->paragraph,
        "guildRealm"    =>  $faker->word,
        'lastModified'  =>  $faker->date()
    ];
});

$factory->define(App\BattleNet\CharacterSpec::class, function (Faker\Generator $faker) {
    $roles = ['damage', 'healer', 'tank'];
    return [
        'name'  =>  $faker->name,
        'role'  =>  $roles[array_rand($roles, 1)],
        'backgroundImage'   =>  $faker->imageUrl(),
        'icon'  =>  $faker->imageUrl(),
        'description'   =>  $faker->sentence(),
        'order' =>  $faker->numberBetween(0, 3)
    ];
});

