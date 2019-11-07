<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\Models\TagService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TagsController extends Controller
{

    /**
     * @var TagService
     */
    protected $tagService;

    /**
     * TagsController constructor.
     *
     * @param TagService $tagService
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Tag::class);

        $tags = Tag::query()
            ->filter($request)
            ->get();

        return $this->json(TagResource::collection($tags), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Tag::class);

        $tags = Tag::query()
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return TagResource::collection($tags);
    }

    /**
     * @param TagRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(TagRequest $request)
    {
        $tag = $this->tagService->create($request->validated());

        return $this->json(new TagResource($tag), Response::HTTP_CREATED);
    }

    /**
     * @param Tag $tag
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Tag $tag)
    {
        $this->authorize('view', Tag::class);

        return $this->json(new TagResource($tag), Response::HTTP_OK);
    }

    /**
     * @param TagRequest $request
     * @param Tag $tag
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag = $this->tagService->update($tag, $request->validated());

        return $this->json(new TagResource($tag), Response::HTTP_OK);
    }

    /**
     * @param Tag $tag
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('delete', Tag::class);

        $tag->delete();

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
        $this->authorize('delete', Tag::class);

        collect($request->get('items'))->each(function ($tag) {
            if ($tagToDelete = Tag::find($tag['id'])) {
                $tagToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
