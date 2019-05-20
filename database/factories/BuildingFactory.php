<?php

use Faker\Generator as Faker;
use App\Models\Place;

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

$factory->define(App\Models\Building::class, function (Faker $faker) {

    $place = factory(Place::class)->create();

    return [
        'name' => $faker->company,
        'place_id' => $place,
        'latitude' => $place->latitude,
        'longitude' => $place->longitude,
    ];
});
