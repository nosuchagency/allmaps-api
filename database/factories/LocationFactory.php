<?php

use Faker\Generator as Faker;
use App\Models\Floor;

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

$factory->define(App\Models\Location::class, function (Faker $faker) {
    return [
        'name' => $faker->title,
        'floor_id' => factory(Floor::class)->create(),
        'poi_id' => null,
        'fixture_id' => null,
        'beacon_id' => null
    ];
});
