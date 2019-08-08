<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\ContentRequest;
use App\Http\Resources\ContentResource;
use App\Models\Content\Content;
use App\Services\Models\ContentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContentsController extends Controller
{

    /**
     * @var ContentService
     */
    protected $contentService;

    /**
     * ContentsController constructor.
     *
     * @param ContentService $contentService
     */
    public function __construct(ContentService $contentService)
    {
        $this->middleware('permission:contents.create')->only(['store']);
        $this->middleware('permission:contents.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:contents.update')->only(['update']);
        $this->middleware('permission:contents.delete')->only(['destroy', 'bulkDestroy']);

        $this->contentService = $contentService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $contents = Content::query()
            ->filter($request)
            ->get();

        return $this->json(ContentResource::collection($contents), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $contents = Content::query()
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return ContentResource::collection($contents);
    }

    /**
     * @param ContentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ContentRequest $request)
    {
        $content = $this->contentService->create($request);

        return $this->json($content, Response::HTTP_CREATED);
    }

    /**
     * @param Content $content
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Content $content)
    {
        return $this->json(new ContentResource($content), Response::HTTP_OK);
    }

    /**
     * @param ContentRequest $request
     * @param Content $content
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContentRequest $request, Content $content)
    {
        $content = $this->contentService->update($content, $request);

        return $this->json($content, Response::HTTP_OK);
    }

    /**
     * @param Content $content
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Content $content)
    {
        $content->delete();

        return $this->json(null, Response::HTTP_OK);
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

        return $this->json(null, Response::HTTP_OK);
    }
}
