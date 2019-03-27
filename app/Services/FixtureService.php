<?php

namespace App\Services;

use App\Http\Requests\FixtureRequest;
use App\Models\Fixture;
use App\Models\Tag;

class FixtureService
{
    /**
     * @param FixtureRequest $request
     *
     * @return Fixture
     */
    public function create(FixtureRequest $request): Fixture
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
     * @param FixtureRequest $request
     * @param Fixture $fixture
     *
     * @return Fixture
     */
    public function update(FixtureRequest $request, Fixture $fixture): Fixture
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