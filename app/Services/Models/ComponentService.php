<?php

namespace App\Services\Models;

use App\Models\Category;
use App\Models\Component;
use App\Models\Tag;
use Illuminate\Support\Arr;

class ComponentService
{
    /**
     * @param array $attributes
     *
     * @return Component
     */
    public function create(array $attributes): Component
    {
        $component = new Component();

        $fields = Arr::only($attributes, [
            'name',
            'type',
            'shape',
            'description',
            'stroke',
            'stroke_type',
            'stroke_color',
            'stroke_width',
            'stroke_opacity',
            'fill',
            'fill_color',
            'fill_opacity',
            'image_width',
            'image_height',
        ]);

        $component->fill($fields);

        if (Arr::has($attributes, 'image')) {
            $component->setImage(Arr::get($attributes, 'image'));
        }

        if (Arr::has($attributes, 'category')) {
            $component->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $component->save();

        if (Arr::has($attributes, 'tags')) {
            foreach ($attributes['tags'] as $tag) {
                $component->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $component->refresh();
    }

    /**
     * @param Component $component
     * @param array $attributes
     *
     * @return Component
     */
    public function update(Component $component, array $attributes): Component
    {
        $fields = Arr::only($attributes, [
            'name',
            'type',
            'shape',
            'description',
            'stroke',
            'stroke_type',
            'stroke_color',
            'stroke_width',
            'stroke_opacity',
            'fill',
            'fill_color',
            'fill_opacity',
            'image_width',
            'image_height',
        ]);

        $component->fill($fields);

        if (Arr::has($attributes, 'image')) {
            $component->setImage(Arr::get($attributes, 'image'));
        }

        if (Arr::has($attributes, 'category')) {
            $component->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $component->save();

        if (Arr::has($attributes, 'tags')) {
            $component->tags()->sync([]);

            foreach ($attributes['tags'] as $tag) {
                $component->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $component->refresh();
    }
}
