<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileContentRequest;
use App\Http\Resources\ContentResource;
use App\Models\Container;
use App\Models\Content\FileContent;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Http\Response;

class FileContentsController extends Controller
{

    /**
     * BuildingsController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:contents.create')->only(['store']);
        $this->middleware('permission:contents.update')->only(['update']);
        $this->middleware('permission:contents.delete')->only(['destroy']);
    }

    /**
     * @param FileContentRequest $request
     * @param Container $container
     * @param Folder $folder
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FileContentRequest $request, Container $container, Folder $folder)
    {
        $file = new FileContent($request->validated());
        $file->container()->associate($container);
        $file = $folder->files()->save($file);

        foreach ($request->get('tags', []) as $tag) {
            $file->tags()->attach(Tag::find($tag['id']));
        }

        return response()->json(new ContentResource($file), Response::HTTP_CREATED);
    }

    /**
     * @param FileContentRequest $request
     * @param Container $container
     * @param Folder $folder
     * @param FileContent $file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FileContentRequest $request, Container $container, Folder $folder, FileContent $file)
    {
        $file->fill($request->validated())->save();

        $file->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $file->tags()->attach(Tag::find($tag['id']));
        }

        return response()->json(new ContentResource($file), Response::HTTP_OK);
    }

    /**
     * @param Container $container
     * @param Folder $folder
     * @param FileContent $file
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Container $container, Folder $folder, FileContent $file)
    {
        $file->delete();

        return response()->json(null, Response::HTTP_OK);
    }
}
