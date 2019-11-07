<?php

namespace App\Services\Models;

use App\Models\Building;
use App\Models\Place;
use Illuminate\Http\Request;

class BuildingService
{
    /**
     * @param Request $request
     *
     * @return Building
     */
    public function create(Request $request): Building
    {
        $building = new Building();

        $place = Place::find($request->input('place.id'));
        $building->place()->associate($place);
        $building->fill($request->only($building->getFillable()));
        $building->setImage($request->get('image'));

        if ($request->filled('menu')) {
            $building->menu()->associate(
                $request->input('menu.id')
            );
        }

        if (!$building->latitude || !$building->longitude) {
            $building->latitude = $building->place->latitude;
            $building->longitude = $building->place->longitude;
        }

        $building->save();

        return $building->refresh();
    }

    /**
     * @param Building $building
     * @param Request $request
     *
     * @return Building
     */
    public function update(Building $building, Request $request): Building
    {
        $building->fill($request->only($building->getFillable()));
        $building->setImage($request->get('image'));

        if (!$building->latitude || !$building->longitude) {
            $building->latitude = $building->place->latitude;
            $building->longitude = $building->place->longitude;
        }

        if ($request->has('place')) {
            $building->place()->associate(
                $request->input('place.id')
            );
        }

        if ($request->has('menu')) {
            $building->menu()->associate(
                $request->input('menu.id')
            );
        }

        $building->save();

        return $building->refresh();
    }
}
