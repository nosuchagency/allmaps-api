<?php

use Faker\Generator as Faker;

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

$factory->define(App\Models\Import::class, function (Faker $faker) {
    return [
        'type' => $faker->randomElement(['beacon']),
        'started_at' => now(),
        'finished_at' => now()->addMinute(),
        'status' => $faker->boolean,
        'count' => $faker->numberBetween(0, 100)
    ];
});
