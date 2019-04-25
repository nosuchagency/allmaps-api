<?php

namespace App\Services;

use App\Contracts\ModelServiceContract;
use App\Models\Place;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PlaceService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $place = new Place();
        $place->fill($request->only($place->getFillable()));
        $place->setImage($request->get('image'));
        $place->save();

        foreach ($request->get('tags', []) as $tag) {
            $place->tags()->attach(Tag::find($tag['id']));
        }

        return $place->refresh();
    }

    /**
     * @param Request $request
     * @param Model $place
     *
     * @return Model
     */
    public function update(Model $place, Request $request)
    {
        $place->fill($request->only($place->getFillable()));
        $place->setImage($request->get('image'));
        $place->save();

        $place->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $place->tags()->attach(Tag::find($tag['id']));
        }

        return $place->refresh();
    }
}