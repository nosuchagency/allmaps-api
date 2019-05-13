<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Tag;
use App\Models\Template;
use App\Models\Token;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TemplateService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $template = new Template();
        $template->layout()->associate(
            $request->input('layout.id')
        );
        $template->fill($request->only($template->getFillable()));
        $template->save();

        foreach ($request->get('tags', []) as $tag) {
            $template->tags()->attach(Tag::find($tag['id']));
        }

        return $template->refresh();
    }

    /**
     * @param Request $request
     * @param Model $template
     *
     * @return Model
     */
    public function update(Model $template, Request $request)
    {
        $template->fill($request->only($template->getFillable()));

        if ($request->filled('layout')) {
            $template->layout()->associate(
                $request->input('layout.id')
            );
        }

        $template->save();

        $template->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $template->tags()->attach(Tag::find($tag['id']));
        }

        return $template->refresh();
    }
}