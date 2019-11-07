<?php

namespace App\Services\Models;

use App\Factories\ContentFactory;
use App\Models\Content\Content;
use App\Models\Tag;
use Illuminate\Http\Request;

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
     * @param Request $request
     *
     * @return Content
     */
    public function create(Request $request): Content
    {
        $content = $this->contentFactory->make($request->get('type'));

        $content->folder()->associate(
            $request->input('folder.id')
        );

        $content->fill($request->only($content->getFillable()));
        $content->setImage($request->get('image'));
        $content->save();

        foreach ($request->get('tags', []) as $tag) {
            $content->tags()->attach(Tag::find($tag['id']));
        }

        return $content->refresh();
    }

    /**
     * @param Content $content
     * @param Request $request
     *
     * @return Content
     */
    public function update(Content $content, Request $request): Content
    {
        $content->fill($request->only($content->getFillable()));
        $content->setImage($request->get('image'));

        if ($request->has('folder')) {
            $content->folder()->associate(
                $request->input('folder.id')
            );
        }

        $content->save();

        $content->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $content->tags()->attach(Tag::find($tag['id']));
        }

        return $content->refresh();
    }
}
