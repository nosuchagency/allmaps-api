<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\ContentRequest;
use App\Models\Container;
use App\Models\Content\Content;
use App\Models\Folder;
use Illuminate\Http\Response;

class ContentsController extends Controller
{

    /**
     * @param ContentRequest $request
     * @param Container $container
     * @param Folder $folder
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ContentRequest $request, Container $container, Folder $folder)
    {
        $contentArgs = array_merge(
            $request->validated(), [
                'container_id' => $container->id
            ]
        );

        $content = $folder->contents()->create($contentArgs);

        return response()->json($content, Response::HTTP_CREATED);
    }

    /**
     * @param ContentRequest $request
     * @param Container $container
     * @param Folder $folder
     * @param Content $content
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContentRequest $request, Container $container, Folder $folder, Content $content)
    {
        $content->fill($request->only('title'))->save();

        return response()->json($content, Response::HTTP_OK);
    }

    /**
     * @param Container $container
     * @param Folder $folder
     * @param Content $content
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Container $container, Folder $folder, Content $content)
    {
        $content->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($content) {
            if ($contentToDelete = Content::find($content['id'])) {
                $contentToDelete->delete();
            }
        });

        return response()->json(null, Response::HTTP_OK);
    }
}
