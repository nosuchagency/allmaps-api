<?php

namespace App\Services;

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
        $building->place()->associate(
            Place::find($request->input('place.id'))
        );

        $building->fill($request->only($building->getFillable()));
        $building->setImage($request->get('image'));

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
        $building->save();

        return $building->refresh();
    }
}