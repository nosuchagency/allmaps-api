<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Floor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FloorService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $floor = new Floor();
        $floor->building()->associate(
            $request->input('building.id')
        );

        $floor->fill($request->only($floor->getFillable()));

        $floor->save();

        return $floor->refresh();
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