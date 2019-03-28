<?php

namespace App\Services;

use App\Http\Requests\PoiRequest;
use App\Models\Poi;
use App\Models\Tag;

class PoiService
{
    /**
     * @param PoiRequest $request
     *
     * @return Poi
     */
    public function create(PoiRequest $request): Poi
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
     * @param PoiRequest $request
     * @param Poi $poi
     *
     * @return Poi
     */
    public function update(PoiRequest $request, Poi $poi): Poi
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