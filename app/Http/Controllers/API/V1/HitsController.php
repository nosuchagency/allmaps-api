<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\HitRequest;
use App\Http\Resources\HitResource;
use App\Models\Hit;
use App\Services\Models\HitService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class HitsController extends Controller
{

    /**
     * @var HitService
     */
    protected $hitService;

    /**
     * HitsController constructor.
     *
     * @param HitService $hitService
     */
    public function __construct(HitService $hitService)
    {
        $this->middleware('permission:hits.create')->only(['store']);
        $this->middleware('permission:hits.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:hits.update')->only(['update']);
        $this->middleware('permission:hits.delete')->only(['destroy', 'bulkDestroy']);

        $this->hitService = $hitService;
    }

    /**
     *
     * @return JsonResponse
     */
    public function index()
    {
        $hits = Hit::query()
            ->get();

        return $this->json(HitResource::collection($hits), Response::HTTP_OK);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function paginated()
    {
        $hits = Hit::query()
            ->jsonPaginate($this->paginationNumber());

        return HitResource::collection($hits);
    }

    /**
     * @param HitRequest $request
     *
     * @return JsonResponse
     */
    public function store(HitRequest $request)
    {
        $hit = $this->hitService->create($request);

        return $this->json(new HitResource($hit), Response::HTTP_CREATED);
    }

    /**
     * @param Hit $hit
     *
     * @return JsonResponse
     */
    public function show(Hit $hit)
    {
        return $this->json(new HitResource($hit), Response::HTTP_OK);
    }

    /**
     * @param Hit $hit
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Hit $hit)
    {
        $hit->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($hit) {
            if ($hitToDelete = Hit::find($hit['id'])) {
                $hitToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
