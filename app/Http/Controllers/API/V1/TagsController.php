<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\Models\TagService;
use Illuminate\Http\Request;
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
        $this->middleware('permission:tags.create')->only(['store']);
        $this->middleware('permission:tags.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:tags.update')->only(['update']);
        $this->middleware('permission:tags.delete')->only(['destroy', 'bulkDestroy']);

        $this->tagService = $tagService;
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $tags = Tag::query()
            ->filter($request)
            ->get();

        return $this->json(TagResource::collection($tags), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $tags = Tag::query()
            ->filter($request)
            ->paginate($this->paginationNumber());

        return TagResource::collection($tags);
    }

    /**
     * @param TagRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TagRequest $request)
    {
        $tag = $this->tagService->create($request);

        return $this->json(new TagResource($tag), Response::HTTP_CREATED);
    }

    /**
     * @param Tag $tag
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Tag $tag)
    {
        return $this->json(new TagResource($tag), Response::HTTP_OK);
    }

    /**
     * @param TagRequest $request
     * @param Tag $tag
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag = $this->tagService->update($tag, $request);

        return $this->json(new TagResource($tag), Response::HTTP_OK);
    }

    /**
     * @param Tag $tag
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($tag) {
            if ($tagToDelete = Tag::find($tag['id'])) {
                $tagToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
