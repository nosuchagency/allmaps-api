<?php

namespace App\Services\Models;

use App\Models\Tag;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateService
{
    /**
     * @param Request $request
     *
     * @return Template
     */
    public function create(Request $request): Template
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
     * @param Template $template
     *
     * @return Template
     */
    public function update(Template $template, Request $request): Template
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
