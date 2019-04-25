<?php

namespace App\Services;

use App\Contracts\ModelServiceContract;
use App\Factories\ContentFactory;
use App\Models\Folder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ContentService implements ModelServiceContract
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
     * @return Model
     */
    public function create(Request $request)
    {
        $content = $this->contentFactory->make($request->get('type'));

        $content->folder()->associate(
            Folder::find($request->input('folder.id'))
        );

        $content->fill($request->only($content->getFillable()));
        $content->save();

        return $content->refresh();
    }

    /**
     * @param Model $content
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $content, Request $request)
    {
        $content->fill($request->only($content->getFillable()));
        $content->save();

        return $content->refresh();
    }
}