<?php

namespace App\Services;

use App\Http\Requests\ComponentRequest;
use App\Models\Component;
use App\Models\Tag;

class ComponentService
{
    /**
     * @param ComponentRequest $request
     *
     * @return Component
     */
    public function create(ComponentRequest $request): Component
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
     * @param ComponentRequest $request
     * @param Component $component
     *
     * @return Component
     */
    public function update(ComponentRequest $request, Component $component): Component
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