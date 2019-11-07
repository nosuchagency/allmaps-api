<?php

namespace App\Services\Models;

use App\Models\Category;
use App\Models\Poi;
use App\Models\Tag;
use Illuminate\Support\Arr;

class PoiService
{
    /**
     * @param array $attributes
     *
     * @return Poi
     */
    public function create(array $attributes): Poi
    {
        $poi = new Poi();

        $fields = Arr::only($attributes, [
            'name',
            'description',
            'image',
            'type',
            'stroke',
            'stroke_type',
            'stroke_color',
            'stroke_width',
            'stroke_opacity',
            'fill',
            'fill_color',
            'fill_opacity',
        ]);

        $poi->fill($fields);

        if (Arr::has($attributes, 'image')) {
            $poi->setImage(Arr::get($attributes, 'image'));
        }

        if (Arr::has($attributes, 'category')) {
            $poi->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $poi->save();

        if (Arr::has($attributes, 'tags')) {
            foreach ($attributes['tags'] as $tag) {
                $poi->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $poi->refresh();
    }

    /**
     * @param Poi $poi
     * @param array $attributes
     *
     * @return Poi
     */
    public function update(Poi $poi, array $attributes): Poi
    {
        $fields = Arr::only($attributes, [
            'name',
            'description',
            'image',
            'type',
            'stroke',
            'stroke_type',
            'stroke_color',
            'stroke_width',
            'stroke_opacity',
            'fill',
            'fill_color',
            'fill_opacity',
        ]);

        $poi->fill($fields);

        if (Arr::has($attributes, 'image')) {
            $poi->setImage(Arr::get($attributes, 'image'));
        }

        if (Arr::has($attributes, 'category')) {
            $poi->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $poi->save();

        if (Arr::has($attributes, 'tags')) {
            $poi->tags()->sync([]);

            foreach ($attributes['tags'] as $tag) {
                $poi->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $poi->refresh();
    }
}
