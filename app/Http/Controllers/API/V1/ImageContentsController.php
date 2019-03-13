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
     * @param ImageContentRequest $request
     * @param Container $container
     * @param Folder $folder
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ImageContentRequest $request, Container $container, Folder $folder)
    {
        $image = new ImageContent($request->except('image'));
        $image->container()->associate($container);
        $image = $folder->images()->save($image);
        $image->setImage($request->get('image'));
        $image->save();

        foreach ($request->get('tags') as $tag) {
            $image->tags()->attach(Tag::find($tag['id']));
        }

        return response()->json(new ContentResource($image), Response::HTTP_CREATED);
    }

    /**
     * @param ImageContentRequest $request
     * @param Container $container
     * @param Folder $folder
     * @param ImageContent $image
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ImageContentRequest $request, Container $container, Folder $folder, ImageContent $image)
    {
        $image->fill($request->except('image'))->save();
        $image->setImage($request->get('image'));
        $image->save();

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
