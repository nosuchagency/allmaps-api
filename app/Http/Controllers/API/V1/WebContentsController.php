<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebContentRequest;
use App\Http\Resources\ContentResource;
use App\Models\Container;
use App\Models\Content\WebContent;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Http\Response;

class WebContentsController extends Controller
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
     * @param WebContentRequest $request
     * @param Container $container
     * @param Folder $folder
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(WebContentRequest $request, Container $container, Folder $folder)
    {
        $web = new WebContent($request->validated());
        $web->container()->associate($container);
        $web = $folder->web()->save($web);

        foreach ($request->get('tags') as $tag) {
            $web->tags()->attach(Tag::find($tag['id']));
        }

        return response()->json(new ContentResource($web), Response::HTTP_CREATED);
    }

    /**
     * @param WebContentRequest $request
     * @param Container $container
     * @param Folder $folder
     * @param WebContent $web
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(WebContentRequest $request, Container $container, Folder $folder, WebContent $web)
    {
        $web->fill($request->validated())->save();

        $web->tags()->sync([]);

        foreach ($request->get('tags') as $tag) {
            $web->tags()->attach(Tag::find($tag['id']));
        }

        return response()->json(new ContentResource($web), Response::HTTP_OK);
    }

    /**
     * @param Container $container
     * @param Folder $folder
     * @param WebContent $web
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Container $container, Folder $folder, WebContent $web)
    {
        $web->delete();

        return response()->json(null, Response::HTTP_OK);
    }
}
