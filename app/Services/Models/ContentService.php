<?php

namespace App\Services\Models;

use App\Factories\ContentFactory;
use App\Models\Category;
use App\Models\Content\Content;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Support\Arr;

class ContentService
{
    /**
     * @var ContentFactory
     */
    protected $contentFactory;

    /**
     * ContentService constructor.
     */
    public function __construct()
    {
        $this->contentFactory = new ContentFactory();
    }

    /**
     * @param array $attributes
     *
     * @return Content
     */
    public function create(array $attributes): Content
    {
        $content = $this->contentFactory->make(Arr::get($attributes, 'type'));

        $fields = Arr::only($attributes, [
            'name',
            'type',
            'file',
            'url',
            'text',
            'yt_url',
            'order',
        ]);

        $content->fill($fields);

        $content->folder()->associate(
            Folder::find(Arr::get($attributes, 'folder.id'))
        );

        if (Arr::has($attributes, 'image')) {
            $content->setImage(Arr::get($attributes, 'image'));
        }

        if (Arr::has($attributes, 'category')) {
            $content->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $content->save();

        if (Arr::has($attributes, 'tags')) {
            foreach ($attributes['tags'] as $tag) {
                $content->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $content->refresh();
    }

    /**
     * @param Content $content
     * @param array $attributes
     *
     * @return Content
     */
    public function update(Content $content, array $attributes): Content
    {
        $fields = Arr::only($attributes, [
            'name',
            'type',
            'file',
            'url',
            'text',
            'yt_url',
            'order',
        ]);

        $content->fill($fields);

        if (Arr::has($attributes, 'image')) {
            $content->setImage(Arr::get($attributes, 'image'));
        }

        if (Arr::has($attributes, 'folder')) {
            $content->folder()->associate(
                Folder::find(Arr::get($attributes, 'folder.id'))
            );
        }

        if (Arr::has($attributes, 'category')) {
            $content->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $content->save();

        if (Arr::has($attributes, 'tags')) {
            $content->tags()->sync([]);

            foreach ($attributes['tags'] as $tag) {
                $content->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $content->refresh();
    }
}
