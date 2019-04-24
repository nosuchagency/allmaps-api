<?php

namespace App\Services;

use App\Contracts\ModelServiceContract;
use App\Http\Requests\LocationRequest;
use App\Models\Beacon;
use App\Models\Fixture;
use App\Models\Location;
use App\Models\LocationField;
use App\Models\Poi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LocationService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $location = new Location();

        $location->floor_id = $request->input('floor.id');

        $location->fill($request->only($location->getFillable()));

        $location->setImage($request->get('image'));

        if ($poiId = $request->input('poi.id')) {
            $associated = Poi::find($poiId);
            $location->poi()->associate($associated);
        } else if ($fixtureId = $request->input('fixture.id')) {
            $associated = Fixture::find($fixtureId);
            $location->fixture()->associate($associated);
        } else if ($beaconId = $request->input('beacon.id')) {
            $associated = Beacon::find($beaconId);
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
     * @param Model $location
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $location, Request $request)
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
     * @param Model $location
     */
    protected function setPluginFields(array $searchables, Model $location)
    {
        foreach ($searchables as $searchable) {
            foreach ($searchable['fields'] as $field) {
                $attributes = [
                    'searchable_id' => $searchable['id'],
                    'identifier' => $field['identifier'],
                    'map_location_id' => $location->id
                ];

                LocationField::updateOrCreate($attributes, [
                    'type' => $field['type'],
                    'value' => $field['value'],
                    'label' => $field['label']
                ]);
            }
        }
    }
}