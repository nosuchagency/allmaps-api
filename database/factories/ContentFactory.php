<?php

use Faker\Generator as Faker;
use App\Models\Folder;

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

$factory->define(App\Models\Content\Content::class, function (Faker $faker) {
    return [
        'name' => $faker->title,
        'type' => $this->faker->randomElement(['image', 'video', 'text', 'gallery', 'file', 'web']),
        'folder_id' => factory(Folder::class)->create()
    ];
});
