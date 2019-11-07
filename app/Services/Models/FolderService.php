<?php

namespace App\Services\Models;

use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Http\Request;

class FolderService
{
    /**
     * @param Request $request
     *
     * @return Folder
     */
    public function create(Request $request): Folder
    {
        $folder = new Folder();
        $folder->container()->associate(
            $request->input('container.id')
        );
        $folder->fill($request->only($folder->getFillable()));
        $folder->save();

        foreach ($request->get('tags', []) as $tag) {
            $folder->tags()->attach(Tag::find($tag['id']));
        }

        return $folder->refresh();
    }

    /**
     * @param Folder $folder
     * @param Request $request
     *
     * @return Folder
     */
    public function update(Folder $folder, Request $request): Folder
    {
        $folder->fill($request->only($folder->getFillable()));

        if ($request->has('container')) {
            $folder->container()->associate(
                $request->input('container.id')
            );
        }

        $folder->save();

        $folder->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $folder->tags()->attach(Tag::find($tag['id']));
        }

        return $folder->refresh();
    }
}
