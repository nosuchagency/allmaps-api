<?php

namespace App\Services\Models;

use App\Models\Poi;
use App\Models\Tag;
use Illuminate\Http\Request;

class PoiService
{
    /**
     * @param Request $request
     *
     * @return Poi
     */
    public function create(Request $request): Poi
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
     * @param Poi $poi
     * @param Request $request
     *
     * @return Poi
     */
    public function update(Poi $poi, Request $request): Poi
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
