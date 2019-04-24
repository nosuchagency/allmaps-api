<?php

use Faker\Generator as Faker;
use App\Models\Floor;
use App\Models\Component;

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

$factory->define(App\Models\Structure::class, function (Faker $faker) {
    return [
        'name' => $faker->title,
        'floor_id' => factory(Floor::class)->create(),
        'component_id' => factory(Component::class)->create(),
    ];
});
