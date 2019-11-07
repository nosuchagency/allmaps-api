<?php

namespace App\Services\Models;

use App\Models\Building;
use App\Models\Menu;
use App\Models\Place;
use Illuminate\Support\Arr;

class BuildingService
{
    /**
     * @param array $attributes
     *
     * @return Building
     */
    public function create(array $attributes): Building
    {
        $building = new Building();

        $fields = Arr::only($attributes, [
            'name',
            'latitude',
            'longitude',
        ]);

        $building->fill($fields);

        $building->place()->associate(
            Place::find(Arr::get($attributes, 'place.id'))
        );

        if (Arr::has($attributes, 'image')) {
            $building->setImage(Arr::get($attributes, 'image'));
        }

        if (Arr::has($attributes, 'menu')) {
            $building->menu()->associate(
                Menu::find(Arr::get($attributes, 'menu.id'))
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
     * @param array $attributes
     *
     * @return Building
     */
    public function update(Building $building, array $attributes): Building
    {
        $fields = Arr::only($attributes, [
            'name',
            'latitude',
            'longitude',
        ]);

        $building->fill($fields);

        if (Arr::has($attributes, 'image')) {
            $building->setImage(Arr::get($attributes, 'image'));
        }

        if (Arr::has($attributes, 'place')) {
            $building->place()->associate(
                Place::find(Arr::get($attributes, 'place.id'))
            );
        }

        if (Arr::has($attributes, 'menu')) {
            $building->menu()->associate(
                Menu::find(Arr::get($attributes, 'menu.id'))
            );
        }

        if (!$building->latitude || !$building->longitude) {
            $building->latitude = $building->place->latitude;
            $building->longitude = $building->place->longitude;
        }

        $building->save();

        return $building->refresh();
    }
}
