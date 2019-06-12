<?php

use App\Pivots\BeaconContainer;
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

$factory->define(App\Models\Hit::class, function (Faker $faker) {
    return [
        'hittable_type' => 'beacon_container',
        'hittable_id' => factory(BeaconContainer::class)->create()
    ];
});
