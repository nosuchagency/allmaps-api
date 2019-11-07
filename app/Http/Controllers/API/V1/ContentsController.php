<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\ContentRequest;
use App\Http\Resources\ContentResource;
use App\Models\Content\Content;
use App\Services\Models\ContentService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
        $this->contentService = $contentService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Content::class);

        $contents = Content::query()
            ->filter($request)
            ->get();

        return $this->json(ContentResource::collection($contents), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Content::class);

        $contents = Content::query()
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return ContentResource::collection($contents);
    }

    /**
     * @param ContentRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(ContentRequest $request)
    {
        $content = $this->contentService->create($request);

        return $this->json(new ContentResource($content), Response::HTTP_CREATED);
    }

    /**
     * @param Content $content
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Content $content)
    {
        $this->authorize('view', Content::class);

        return $this->json(new ContentResource($content), Response::HTTP_OK);
    }

    /**
     * @param ContentRequest $request
     * @param Content $content
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(ContentRequest $request, Content $content)
    {
        $content = $this->contentService->update($content, $request);

        return $this->json(new ContentResource($content), Response::HTTP_OK);
    }

    /**
     * @param Content $content
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Content $content)
    {
        $this->authorize('delete', Content::class);

        $content->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        $this->authorize('delete', Content::class);

        collect($request->get('items'))->each(function ($content) {
            if ($contentToDelete = Content::find($content['id'])) {
                $contentToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
