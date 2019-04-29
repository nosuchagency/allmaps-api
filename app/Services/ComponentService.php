<?php

namespace App\Services;

use App\Contracts\ModelServiceContract;
use App\Models\Component;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ComponentService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $component = new Component();

        $component->fill($request->only($component->getFillable()));
        $component->setImage($request->get('image'));

        $component->save();

        foreach ($request->get('tags', []) as $tag) {
            $component->tags()->attach(Tag::find($tag['id']));
        }

        return $component->refresh();
    }

    /**
     * @param Model $component
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $component, Request $request)
    {
        $component->fill($request->only($component->getFillable()));
        $component->setImage($request->get('image'));
        $component->save();

        $component->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $component->tags()->attach(Tag::find($tag['id']));
        }

        return $component->refresh();
    }
}