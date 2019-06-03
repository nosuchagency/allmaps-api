<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Beacon;
use App\Models\Fixture;
use App\Models\Location;
use App\Models\LocationField;
use App\Models\Poi;
use App\Models\Tag;
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

        $location->floor()->associate(
            $request->input('floor.id')
        );

        $location->fill($request->only($location->getFillable()));
        $location->setImage($request->get('image'));

        if ($request->filled('poi')) {
            $locatable = Poi::find($request->input('poi.id'));
        } else if ($request->filled('fixture')) {
            $locatable = Fixture::find($request->input('fixture.id'));
        } else if ($request->filled('beacon')) {
            $locatable = Beacon::find($request->input('beacon.id'));
        } else {
            $locatable = null;
        }

        $location->locatable()->associate($locatable);

        if (!$location->name) {
            $location->name = $location->locatable->name;
        }

        $location->save();

        foreach ($request->get('tags', []) as $tag) {
            $location->tags()->attach(Tag::find($tag['id']));
        }

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

        $location->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $location->tags()->attach(Tag::find($tag['id']));
        }

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
                    'location_id' => $location->id
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