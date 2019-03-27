<?php

namespace App\Services;

use App\Http\Requests\MapLocationRequest;
use App\Models\Beacon;
use App\Models\Fixture;
use App\Models\Floor;
use App\Models\MapLocation;
use App\Models\MapLocationField;
use App\Models\Poi;

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
        } else if ($request->has('fixture_id')) {
            $associated = Fixture::find($request->get('fixture_id'));
            $location->fixture()->associate($associated);
        } else if ($request->has('beacon_id')) {
            $associated = Beacon::find($request->get('beacon_id'));
            $location->beacon()->associate($associated);
        }

        if (!$location->name) {
            $location->name = optional($associated)->name;
        }

        $location->save();

        if ($request->has('searchables')) {
            $this->setPluginFields($request->get('searchables'), $location);
        }

        return $location->refresh();
    }

    /**
     * @param MapLocationRequest $request
     * @param MapLocation $location
     *
     * @return MapLocation
     */
    public function update(MapLocationRequest $request, MapLocation $location): MapLocation
    {
        $location->fill($request->only($location->getFillable()));
        $location->setImage($request->get('image'));
        $location->save();

        if ($request->has('searchables')) {
            $this->setPluginFields($request->get('searchables'), $location);
        }

        return $location->refresh();
    }

    /**
     * @param array $searchables
     * @param MapLocation $location
     */
    protected function setPluginFields(array $searchables, MapLocation $location)
    {
        foreach ($searchables as $searchable) {
            foreach ($searchable['fields'] as $field) {
                $attributes = [
                    'searchable_id' => $searchable['id'],
                    'identifier' => $field['identifier'],
                    'map_location_id' => $location->id
                ];

                MapLocationField::updateOrCreate($attributes, [
                    'type' => $field['type'],
                    'value' => $field['value'],
                    'label' => $field['label']
                ]);
            }
        }
    }
}