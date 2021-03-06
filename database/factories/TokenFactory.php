<?php

use App\Models\Role;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(App\Models\Token::class, function (Faker $faker) {
    return [
        'name' => 'Token',
        'api_token' => Str::random(60),
        'role_id' => factory(Role::class),
    ];
});
