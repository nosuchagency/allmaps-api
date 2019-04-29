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

$factory->define(App\Models\Rule::class, function (Faker $faker) {
    return [
        'distance' => $faker->randomElement(['close', 'medium', 'far']),
        'weekday' => $faker->randomElement(['all', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'weekdays', 'weekends']),
        'time_restricted' => $faker->boolean,
        'date_restricted' => $faker->boolean,
        'time_from' => now()->format('H:i'),
        'time_to' => now()->addHour()->format('H:i'),
        'date_from' => now()->format('Y-m-d'),
        'date_to' => now()->addDay()->format('Y-m-d')
    ];
});
