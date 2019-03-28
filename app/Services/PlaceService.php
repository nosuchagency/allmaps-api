<?php

namespace App\Services;

use App\Http\Requests\PlaceRequest;
use App\Models\Place;
use App\Models\Tag;

class PlaceService
{
    /**
     * @param PlaceRequest $request
     *
     * @return Place
     */
    public function create(PlaceRequest $request): Place
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
     * @param PlaceRequest $request
     * @param Place $place
     *
     * @return Place
     */
    public function update(PlaceRequest $request, Place $place): Place
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