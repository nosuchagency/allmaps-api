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

$factory->define(App\Models\Skin::class, function (Faker $faker) {
    return [
        'name' => $faker->uuid,
        'identifier' => $faker->uuid,
        'mobile' => $faker->boolean,
        'tablet' => $faker->boolean,
        'desktop' => $faker->boolean,
    ];
});
