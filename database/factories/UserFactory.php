<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'nip' => $faker->unique()->randomNumber(10),
        'name' => $faker->name,
        'position_id' => $faker->numberBetween(1,5),
        'position_detail_id' => $faker->numberBetween(1,5),
        'email' => $faker->unique()->freeEmail,
        'username' => $faker->userName,
        'password' => Str::random(20), // password
    ];
});
