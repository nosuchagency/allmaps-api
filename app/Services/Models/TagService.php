<?php

namespace App\Services\Models;

use App\Models\Tag;
use Illuminate\Support\Arr;

class TagService
{
    /**
     * @param array $attributes
     *
     * @return Tag
     */
    public function create(array $attributes): Tag
    {
        $tag = new Tag();

        $fields = Arr::only($attributes, [
            'name',
            'description'
        ]);

        $tag->fill($fields)->save();

        return $tag->refresh();
    }

    /**
     * @param Tag $tag
     * @param array $attributes
     *
     * @return Tag
     */
    public function update(Tag $tag, array $attributes): Tag
    {
        $fields = Arr::only($attributes, [
            'name',
            'description'
        ]);

        $tag->fill($fields)->save();

        return $tag->refresh();
    }
}
