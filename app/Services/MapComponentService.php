<?php

namespace App\Services;

use App\Http\Requests\MapComponentRequest;
use App\Models\MapComponent;
use App\Models\Tag;

class MapComponentService
{
    /**
     * @param MapComponentRequest $request
     *
     * @return MapComponent
     */
    public function create(MapComponentRequest $request): MapComponent
    {
        $mapComponent = new MapComponent();

        $mapComponent->fill($request->only($mapComponent->getFillable()));
        $mapComponent->setImage($request->get('image'));

        $mapComponent->save();

        foreach ($request->get('tags', []) as $tag) {
            $mapComponent->tags()->attach(Tag::find($tag['id']));
        }

        return $mapComponent->refresh();
    }

    /**
     * @param MapComponentRequest $request
     * @param MapComponent $mapComponent
     *
     * @return MapComponent
     */
    public function update(MapComponentRequest $request, MapComponent $mapComponent): MapComponent
    {
        $mapComponent->fill($request->only($mapComponent->getFillable()));
        $mapComponent->setImage($request->get('image'));
        $mapComponent->save();

        $mapComponent->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $mapComponent->tags()->attach(Tag::find($tag['id']));
        }

        return $mapComponent->refresh();
    }
}