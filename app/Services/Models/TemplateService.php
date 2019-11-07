<?php

namespace App\Services\Models;

use App\Models\Category;
use App\Models\Layout;
use App\Models\Tag;
use App\Models\Template;
use Illuminate\Support\Arr;

class TemplateService
{
    /**
     * @param array $attributes
     *
     * @return Template
     */
    public function create(array $attributes): Template
    {
        $template = new Template();

        $fields = Arr::only($attributes, [
            'name',
            'description',
            'content',
            'activated',
            'hook',
        ]);

        $template->fill($fields);

        $template->layout()->associate(
            Layout::find(Arr::get($attributes, 'layout.id'))
        );

        if (Arr::has($attributes, 'category')) {
            $template->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $template->save();

        if (Arr::has($attributes, 'tags')) {
            foreach ($attributes['tags'] as $tag) {
                $template->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $template->refresh();
    }

    /**
     * @param array $attributes
     * @param Template $template
     *
     * @return Template
     */
    public function update(Template $template, array $attributes): Template
    {
        $fields = Arr::only($attributes, [
            'name',
            'description',
            'content',
            'activated',
            'hook',
        ]);

        $template->fill($fields);

        if (Arr::has($attributes, 'layout')) {
            $template->layout()->associate(
                Layout::find(Arr::get($attributes, 'layout.id'))
            );
        }

        if (Arr::has($attributes, 'category')) {
            $template->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $template->save();

        if (Arr::has($attributes, 'tags')) {
            $template->tags()->sync([]);

            foreach ($attributes['tags'] as $tag) {
                $template->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $template->refresh();
    }
}
