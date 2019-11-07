<?php

namespace App\Services\Models;

use App\Models\Category;
use App\Models\Container;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Support\Arr;

class FolderService
{
    /**
     * @param array $attributes
     *
     * @return Folder
     */
    public function create(array $attributes): Folder
    {
        $folder = new Folder();

        $fields = Arr::only($attributes, [
            'name',
            'order',
        ]);

        $folder->fill($fields);

        $folder->container()->associate(
            Container::find(Arr::get($attributes, 'container.id'))
        );

        if (Arr::has($attributes, 'category')) {
            $folder->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $folder->save();

        if (Arr::has($attributes, 'tags')) {
            foreach ($attributes['tags'] as $tag) {
                $folder->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $folder->refresh();
    }

    /**
     * @param Folder $folder
     * @param array $attributes
     *
     * @return Folder
     */
    public function update(Folder $folder, array $attributes): Folder
    {
        $fields = Arr::only($attributes, [
            'name',
            'order',
        ]);

        $folder->fill($fields);

        if (Arr::has($attributes, 'container')) {
            $folder->container()->associate(
                Container::find(Arr::get($attributes, 'container.id'))
            );
        }

        if (Arr::has($attributes, 'category')) {
            $folder->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $folder->save();

        if (Arr::has($attributes, 'tags')) {
            $folder->tags()->sync([]);

            foreach ($attributes['tags'] as $tag) {
                $folder->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $folder->refresh();
    }
}
