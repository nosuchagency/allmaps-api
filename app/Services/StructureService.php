<?php

namespace App\Services;

use App\Contracts\ModelServiceContract;
use App\Models\Component;
use App\Models\Floor;
use App\Models\Structure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class StructureService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $structure = new Structure();
        $structure->floor()->associate(
            Floor::find($request->input('floor.id'))
        );

        $structure->component()->associate(
            Component::find($request->input('component.id'))
        );

        $structure->fill($request->only($structure->getFillable()));

        if (!$structure->name) {
            $structure->name = $structure->component->name;
        }

        $structure->save();

        return $structure->refresh();
    }

    /**
     * @param Model $floor
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $floor, Request $request)
    {
        $floor->fill($request->only($floor->getFillable()));
        $floor->save();

        return $floor->refresh();
    }
}