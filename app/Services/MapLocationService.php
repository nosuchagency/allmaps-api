<?php

namespace App\Services;

use App\Http\Requests\MapLocationRequest;
use App\Models\Beacon;
use App\Models\Fixture;
use App\Models\Floor;
use App\Models\MapLocation;
use App\Models\Poi;
use Illuminate\Http\Request;

class MapLocationService
{
    /**
     * @param MapLocationRequest $request
     * @param Floor $floor
     *
     * @return MapLocation
     */
    public function create(MapLocationRequest $request, Floor $floor): MapLocation
    {
        $location = new MapLocation();
        $location->floor()->associate($floor);

        $location->fill($request->only($location->getFillable()));

        $location->setImage($request->get('image'));

        if ($request->has('poi_id')) {
            $associated = Poi::find($request->get('poi_id'));
            $location->poi()->associate($associated);
        }

        if ($request->has('fixture_id')) {
            $associated = Fixture::find($request->get('fixture_id'));
            $location->fixture()->associate($associated);
        }

        if ($request->has('beacon_id')) {
            $associated = Beacon::find($request->get('beacon_id'));
            $location->beacon()->associate($associated);
        }

        if ($request->has('fields')) {
            $this->setPluginFields($request->get('fields'));
        }

        if (!$location->name) {
            $location->name = optional($associated)->name;
        }

        $location->save();

        return $location->refresh();
    }

    /**
     * @param Request $request
     * @param MapLocation $location
     *
     * @return MapLocation
     */
    public function update(Request $request, MapLocation $location): MapLocation
    {
        $location->fill($request->only($location->getFillable()));
        $location->setImage($request->get('image'));
        $location->save();

        return $location->refresh();
    }

    /**
     * @param array $fields
     */
    protected function setPluginFields(array $fields)
    {
        foreach ($fields as $key => $field) {

        }
    }
}