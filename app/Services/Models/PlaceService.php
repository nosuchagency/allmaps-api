<?php

namespace App\Services\Models;

use App\Models\Place;
use App\Models\Tag;
use Illuminate\Http\Request;

class PlaceService
{
    /**
     * @param Request $request
     *
     * @return Place
     */
    public function create(Request $request): Place
    {
        $place = new Place();
        $place->fill($request->only($place->getFillable()));
        $place->setImage($request->get('image'));

        if ($request->filled('menu')) {
            $place->menu()->associate(
                $request->input('menu.id')
            );
        }

        $place->save();

        foreach ($request->get('tags', []) as $tag) {
            $place->tags()->attach(Tag::find($tag['id']));
        }

        return $place->refresh();
    }

    /**
     * @param Request $request
     * @param Place $place
     *
     * @return Place
     */
    public function update(Place $place, Request $request): Place
    {
        $place->fill($request->only($place->getFillable()));
        $place->setImage($request->get('image'));

        if ($request->has('menu')) {
            $place->menu()->associate(
                $request->input('menu.id')
            );
        }

        $place->save();

        $place->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $place->tags()->attach(Tag::find($tag['id']));
        }

        return $place->refresh();
    }
}
