<?php

namespace App\Services\Models;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Place;
use App\Models\Tag;
use Illuminate\Support\Arr;

class PlaceService
{
    /**
     * @param array $attributes
     *
     * @return Place
     */
    public function create(array $attributes): Place
    {
        $place = new Place();

        $fields = Arr::only($attributes, [
            'name',
            'address',
            'postcode',
            'city',
            'latitude',
            'longitude',
            'activated'
        ]);

        $place->fill($fields);

        if (Arr::has($attributes, 'image')) {
            $place->setImage(Arr::get($attributes, 'image'));
        }

        if (Arr::has($attributes, 'menu')) {
            $place->menu()->associate(
                Menu::find(Arr::get($attributes, 'menu.id'))
            );
        }

        if (Arr::has($attributes, 'category')) {
            $place->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $place->save();

        if (Arr::has($attributes, 'tags')) {
            foreach ($attributes['tags'] as $tag) {
                $place->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $place->refresh();
    }

    /**
     * @param array $attributes
     * @param Place $place
     *
     * @return Place
     */
    public function update(Place $place, array $attributes): Place
    {
        $fields = Arr::only($attributes, [
            'name',
            'address',
            'postcode',
            'city',
            'latitude',
            'longitude',
            'activated'
        ]);

        $place->fill($fields);

        if (Arr::has($attributes, 'image')) {
            $place->setImage(Arr::get($attributes, 'image'));
        }

        if (Arr::has($attributes, 'menu')) {
            $place->menu()->associate(
                Menu::find(Arr::get($attributes, 'menu.id'))
            );
        }

        if (Arr::has($attributes, 'category')) {
            $place->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $place->save();

        if (Arr::has($attributes, 'tags')) {
            $place->tags()->sync([]);

            foreach ($attributes['tags'] as $tag) {
                $place->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $place->refresh();
    }
}
