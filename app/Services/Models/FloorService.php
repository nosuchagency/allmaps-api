<?php

namespace App\Services\Models;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Support\Arr;

class FloorService
{
    /**
     * @param array $attributes
     *
     * @return Floor
     */
    public function create(array $attributes): Floor
    {
        $floor = new Floor();

        $fields = Arr::only($attributes, [
            'name',
            'level',
        ]);

        $floor->fill($fields);

        $floor->building()->associate(
            Building::find(Arr::get($attributes, 'building.id'))
        );

        $floor->save();

        return $floor->refresh();
    }

    /**
     * @param Floor $floor
     * @param array $attributes
     *
     * @return Floor
     */
    public function update(Floor $floor, array $attributes): Floor
    {
        $fields = Arr::only($attributes, [
            'name',
            'level',
        ]);

        $floor->fill($fields);

        if (Arr::has($attributes, 'building.id')) {
            $floor->building()->associate(
                Building::find(Arr::get($attributes, 'building.id'))
            );
        }

        $floor->save();

        return $floor->refresh();
    }
}
