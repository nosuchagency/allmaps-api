<?php

namespace App\Services\Models;

use App\Models\Category;
use App\Models\Fixture;
use App\Models\Tag;
use Illuminate\Support\Arr;

class FixtureService
{
    /**
     * @param array $attributes
     *
     * @return Fixture
     */
    public function create(array $attributes): Fixture
    {
        $fixture = new Fixture();

        $fields = Arr::only($attributes, [
            'name',
            'description',
            'image',
            'image_width',
            'image_height',
        ]);

        $fixture->fill($fields);

        if (Arr::has($attributes, 'image')) {
            $fixture->setImage(Arr::get($attributes, 'image'));
        }

        if (Arr::has($attributes, 'category')) {
            $fixture->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $fixture->save();

        if (Arr::has($attributes, 'tags')) {
            foreach ($attributes['tags'] as $tag) {
                $fixture->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $fixture->refresh();
    }

    /**
     * @param Fixture $fixture
     * @param array $attributes
     *
     * @return Fixture
     */
    public function update(Fixture $fixture, array $attributes): Fixture
    {
        $fields = Arr::only($attributes, [
            'name',
            'description',
            'image',
            'image_width',
            'image_height',
        ]);

        $fixture->fill($fields);

        if (Arr::has($attributes, 'image')) {
            $fixture->setImage(Arr::get($attributes, 'image'));
        }

        if (Arr::has($attributes, 'category')) {
            $fixture->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $fixture->save();

        if (Arr::has($attributes, 'tags')) {
            $fixture->tags()->sync([]);

            foreach ($attributes['tags'] as $tag) {
                $fixture->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $fixture->refresh();
    }
}
