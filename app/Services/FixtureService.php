<?php

namespace App\Services;

use App\Contracts\ModelServiceContract;
use App\Models\Fixture;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FixtureService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $fixture = new Fixture();
        $fixture->fill($request->only($fixture->getFillable()));
        $fixture->setImage($request->get('image'));
        $fixture->save();

        foreach ($request->get('tags', []) as $tag) {
            $fixture->tags()->attach(Tag::find($tag['id']));
        }

        return $fixture->refresh();
    }

    /**
     * @param Model $fixture
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $fixture, Request $request)
    {
        $fixture->fill($request->only($fixture->getFillable()));
        $fixture->setImage($request->get('image'));
        $fixture->save();

        $fixture->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $fixture->tags()->attach(Tag::find($tag['id']));
        }

        return $fixture->refresh();
    }
}