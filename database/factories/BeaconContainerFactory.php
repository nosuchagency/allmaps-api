<?php

use App\Models\Beacon;
use App\Models\Container;
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

$factory->define(App\Pivots\BeaconContainer::class, function (Faker $faker) {
    return [
        'beacon_id' => factory(Beacon::class)->create(),
        'container_id' => factory(Container::class)->create(),
    ];
});
