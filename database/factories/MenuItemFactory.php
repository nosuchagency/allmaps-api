<?php

use Faker\Generator as Faker;
use App\Models\Menu;

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

$factory->define(App\Models\MenuItem::class, function (Faker $faker) {
    return [
        'name' => $faker->title,
        'order' => $faker->numberBetween(0, 10),
        'menu_id' => factory(Menu::class)->create()
    ];
});
