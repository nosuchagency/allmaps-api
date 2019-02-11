<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoContentRequest;
use App\Http\Resources\ContentResource;
use App\Models\Container;
use App\Models\Content\VideoContent;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Http\Response;

class VideoContentsController extends Controller
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
     * @param VideoContentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Container $container, Folder $folder, VideoContentRequest $request)
    {
        $video = new VideoContent($request->validated());
        $video->container()->associate($container);
        $video = $folder->videos()->save($video);

        foreach ($request->get('tags') as $tag) {
            $video->tags()->attach(Tag::find($tag['id']));
        }

        return response()->json(new ContentResource($video), Response::HTTP_CREATED);
    }

    /**
     * @param Container $container
     * @param Folder $folder
     * @param VideoContent $video
     * @param VideoContentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Container $container, Folder $folder, VideoContent $video, VideoContentRequest $request)
    {
        $video->fill($request->validated())->save();

        $video->tags()->sync([]);

        foreach ($request->get('tags') as $tag) {
            $video->tags()->attach(Tag::find($tag['id']));
        }

        return response()->json(new ContentResource($video), Response::HTTP_OK);
    }

    /**
     * @param Container $container
     * @param Folder $folder
     * @param VideoContent $video
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Container $container, Folder $folder, VideoContent $video)
    {
        $video->delete();

        return response()->json(null, Response::HTTP_OK);
    }
}
