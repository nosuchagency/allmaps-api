<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Beacon;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BeaconService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $beacon = new Beacon();
        $beacon->fill($request->only($beacon->getFillable()))->save();

        foreach ($request->get('tags', []) as $tag) {
            $beacon->tags()->attach(Tag::find($tag['id']));
        }

        return $beacon->refresh();
    }

    /**
     * @param Model $beacon
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $beacon, Request $request)
    {
        $beacon->fill($request->only($beacon->getFillable()))->save();
        $beacon->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $beacon->tags()->attach(Tag::find($tag['id']));
        }

        return $beacon->refresh();
    }
}