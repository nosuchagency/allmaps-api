<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Building;
use App\Models\Place;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BuildingService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $building = new Building();

        $place = Place::find($request->input('place.id'));
        $building->place()->associate($place);
        $building->fill($request->only($building->getFillable()));
        $building->setImage($request->get('image'));

        if (!$building->latitude || !$building->longitude) {
            $building->latitude = $building->place->latitude;
            $building->longitude = $building->place->longitude;
        }

        $building->save();

        return $building->refresh();
    }

    /**
     * @param Model $building
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $building, Request $request)
    {
        $building->fill($request->only($building->getFillable()));
        $building->setImage($request->get('image'));

        if (!$building->latitude || !$building->longitude) {
            $building->latitude = $building->place->latitude;
            $building->longitude = $building->place->longitude;
        }

        $building->save();

        return $building->refresh();
    }
}