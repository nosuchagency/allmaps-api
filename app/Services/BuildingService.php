<?php

namespace App\Services;

use App\Http\Requests\BuildingRequest;
use App\Models\Building;
use App\Models\Place;

class BuildingService
{
    /**
     * @param BuildingRequest $request
     * @param Place $place
     *
     * @return Building
     */
    public function create(BuildingRequest $request, Place $place): Building
    {
        $building = new Building();
        $building->place()->associate($place);

        $building->fill($request->only($place->getFillable()));
        $building->setImage($request->get('image'));

        $building->save();

        return $building->refresh();
    }

    /**
     * @param BuildingRequest $request
     * @param Building $building
     *
     * @return Building
     */
    public function update(BuildingRequest $request, Building $building): Building
    {
        $building->fill($request->only($building->getFillable()));
        $building->setImage($request->get('image'));
        $building->save();

        return $building->refresh();
    }
}