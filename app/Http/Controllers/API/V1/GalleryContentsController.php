<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryContentRequest;
use App\Http\Resources\ContentResource;
use App\Models\Container;
use App\Models\Content\GalleryContent;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Http\Response;

class GalleryContentsController extends Controller
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
     * @param Container $container
     * @param Folder $folder
     * @param GalleryContentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Container $container, Folder $folder, GalleryContentRequest $request)
    {
        $gallery = new GalleryContent($request->validated());
        $gallery->container()->associate($container);
        $gallery = $folder->galleries()->save($gallery);

        foreach ($request->get('tags') as $tag) {
            $gallery->tags()->attach(Tag::find($tag['id']));
        }

        return response()->json(new ContentResource($gallery), Response::HTTP_CREATED);
    }

    /**
     * @param Container $container
     * @param Folder $folder
     * @param GalleryContent $gallery
     * @param GalleryContentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Container $container, Folder $folder, GalleryContent $gallery, GalleryContentRequest $request)
    {
        $gallery->fill($request->validated())->save();

        $gallery->tags()->sync([]);

        foreach ($request->get('tags') as $tag) {
            $gallery->tags()->attach(Tag::find($tag['id']));
        }

        return response()->json(new ContentResource($gallery), Response::HTTP_OK);
    }

    /**
     * @param Container $container
     * @param Folder $folder
     * @param GalleryContent $gallery
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Container $container, Folder $folder, GalleryContent $gallery)
    {
        $gallery->delete();

        return response()->json(null, Response::HTTP_OK);
    }
}
