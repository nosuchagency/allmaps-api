<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TagService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $tag = new Tag();
        $tag->fill($request->only($tag->getFillable()))->save();
        return $tag->refresh();
    }

    /**
     * @param Model $tag
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $tag, Request $request)
    {
        $tag->fill($request->only($tag->getFillable()))->save();

        return $tag->refresh();
    }
}