<?php

namespace App\Services\Models;

use App\Models\Component;
use App\Models\Floor;
use App\Models\Structure;
use Illuminate\Support\Arr;

class StructureService
{
    /**
     * @param array $attributes
     *
     * @return Structure
     */
    public function create(array $attributes): Structure
    {
        $structure = new Structure();

        $fields = Arr::only($attributes, [
            'name',
            'coordinates',
            'markers',
            'radius',
        ]);

        $structure->fill($fields);

        if (!$structure->name) {
            $structure->name = $structure->component->name;
        }

        $structure->floor()->associate(
            Floor::find(Arr::get($attributes, 'floor.id'))
        );

        $structure->component()->associate(
            Component::find(Arr::get($attributes, 'component.id'))
        );

        $structure->save();

        return $structure->refresh();
    }

    /**
     * @param Structure $structure
     * @param array $attributes
     *
     * @return Structure
     */
    public function update(Structure $structure, array $attributes): Structure
    {
        $fields = Arr::only($attributes, [
            'name',
            'coordinates',
            'markers',
            'radius',
        ]);

        $structure->fill($fields);

        if (Arr::has($attributes, 'floor')) {
            $structure->floor()->associate(
                Floor::find(Arr::get($attributes, 'floor.id'))
            );
        }

        if (Arr::has($attributes, 'component')) {
            $structure->component()->associate(
                Component::find(Arr::get($attributes, 'component.id'))
            );
        }

        $structure->save();

        return $structure->refresh();
    }
}
