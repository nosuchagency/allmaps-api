<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageContentRequest;
use App\Http\Resources\ContentResource;
use App\Models\Container;
use App\Models\Content\ImageContent;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Http\Response;

class ImageContentsController extends Controller
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
     * @param ImageContentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Container $container, Folder $folder, ImageContentRequest $request)
    {
        $image = new ImageContent($request->except('image'));
        $image->container()->associate($container);
        $image = $folder->images()->save($image);
        $image->addAndSaveImage($request->get('image'));

        foreach ($request->get('tags') as $tag) {
            $image->tags()->attach(Tag::find($tag['id']));
        }

        return response()->json(new ContentResource($image), Response::HTTP_CREATED);
    }

    /**
     * @param Container $container
     * @param Folder $folder
     * @param ImageContent $image
     * @param ImageContentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Container $container, Folder $folder, ImageContent $image, ImageContentRequest $request)
    {
        $image->fill($request->except('image'))->save();
        $image->addAndSaveImage($request->get('image'));

        $image->tags()->sync([]);

        foreach ($request->get('tags') as $tag) {
            $image->tags()->attach(Tag::find($tag['id']));
        }

        return response()->json(new ContentResource($image), Response::HTTP_OK);
    }

    /**
     * @param Container $container
     * @param Folder $folder
     * @param ImageContent $image
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Container $container, Folder $folder, ImageContent $image)
    {
        $image->delete();

        return response()->json(null, Response::HTTP_OK);
    }
}
