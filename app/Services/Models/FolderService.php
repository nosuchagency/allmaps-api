<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FolderService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
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
     * @param Model $folder
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $folder, Request $request)
    {
        $folder->fill($request->only($folder->getFillable()));
        $folder->save();

        $folder->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $folder->tags()->attach(Tag::find($tag['id']));
        }

        return $folder->refresh();
    }
}