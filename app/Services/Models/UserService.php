<?php

namespace App\Services\Models;

use App\Models\Category;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Arr;

class UserService
{
    /**
     * @param array $attributes
     *
     * @return user
     */
    public function create(array $attributes): User
    {
        $user = new User();

        $fields = Arr::only($attributes, [
            'name',
            'email',
            'password',
            'locale',
            'description'
        ]);

        $user->fill($fields);

        $user->role()->associate(
            Role::find(Arr::get($attributes, 'role.id'))
        );

        $user->category()->associate(
            Category::find(Arr::get($attributes, 'category.id'))
        );

        $user->save();

        if (Arr::has($attributes, 'tags')) {
            foreach ($attributes['tags'] as $tag) {
                $user->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $user->refresh();
    }

    /**
     * @param User $user
     * @param array $attributes
     *
     * @return User
     */
    public function update(User $user, array $attributes): User
    {
        $fields = Arr::only($attributes, [
            'name',
            'email',
            'password',
            'locale',
            'description'
        ]);

        $user->fill($fields);

        if (Arr::has($attributes, 'role.id')) {
            $user->role()->associate(
                Role::find(Arr::get($attributes, 'role.id'))
            );
        }

        if (Arr::has($attributes, 'category.id')) {
            $user->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $user->save();

        if (Arr::has($attributes, 'tags')) {
            $user->tags()->sync([]);

            foreach ($attributes['tags'] as $tag) {
                $user->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $user->refresh();
    }
}
