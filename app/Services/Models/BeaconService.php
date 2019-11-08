<?php

namespace App\Services\Models;

use App\Models\Beacon;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Arr;

class BeaconService
{
    /**
     * @param array $attributes
     *
     * @return Beacon
     */
    public function create(array $attributes): Beacon
    {
        $beacon = new Beacon();

        $fields = Arr::only($attributes, [
            'name',
            'description',
            'identifier',
            'proximity_uuid',
            'major',
            'minor',
            'namespace',
            'instance_id',
            'url',
        ]);

        $beacon->fill($fields);

        if (Arr::has($attributes, 'category')) {
            $beacon->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $beacon->save();

        if (Arr::has($attributes, 'tags')) {
            foreach ($attributes['tags'] as $tag) {
                $beacon->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $beacon->refresh();
    }

    /**
     * @param Beacon $beacon
     * @param array $attributes
     *
     * @return Beacon
     */
    public function update(Beacon $beacon, array $attributes): Beacon
    {
        $fields = Arr::only($attributes, [
            'name',
            'description',
            'identifier',
            'proximity_uuid',
            'major',
            'minor',
            'namespace',
            'instance_id',
            'url'
        ]);

        $beacon->fill($fields);

        if (Arr::has($attributes, 'category')) {
            $beacon->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $beacon->save();

        if (Arr::has($attributes, 'tags')) {
            $beacon->tags()->sync([]);

            foreach ($attributes['tags'] as $tag) {
                $beacon->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $beacon->refresh();
    }
}
