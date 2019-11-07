<?php

namespace App\Services\Models;

use App\Models\Structure;
use Illuminate\Http\Request;

class StructureService
{
    /**
     * @param Request $request
     *
     * @return Structure
     */
    public function create(Request $request): Structure
    {
        $structure = new Structure();
        $structure->floor()->associate(
            $request->input('floor.id')
        );

        $structure->component()->associate(
            $request->input('component.id')
        );

        $structure->fill($request->only($structure->getFillable()));

        if (!$structure->name) {
            $structure->name = $structure->component->name;
        }

        $structure->save();

        return $structure->refresh();
    }

    /**
     * @param Structure $structure
     * @param Request $request
     *
     * @return Structure
     */
    public function update(Structure $structure, Request $request): Structure
    {
        $structure->fill($request->only($structure->getFillable()));
        $structure->save();

        return $structure->refresh();
    }
}
