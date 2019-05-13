<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Poi;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PoiService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $poi = new Poi();
        $poi->fill($request->only($poi->getFillable()));
        $poi->setImage($request->get('image'));

        $poi->save();

        foreach ($request->get('tags', []) as $tag) {
            $poi->tags()->attach(Tag::find($tag['id']));
        }

        return $poi->refresh();
    }

    /**
     * @param Model $poi
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $poi, Request $request)
    {
        $poi->fill($request->only($poi->getFillable()));
        $poi->setImage($request->get('image'));
        $poi->save();

        $poi->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $poi->tags()->attach(Tag::find($tag['id']));
        }

        return $poi->refresh();
    }
}