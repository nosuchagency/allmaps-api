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
        $this->hitService = $hitService;
    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function index()
    {
        $this->authorize('viewAny', Hit::class);

        $hits = Hit::query()
            ->get();

        return $this->json(HitResource::collection($hits), Response::HTTP_OK);
    }

    /**
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated()
    {
        $this->authorize('viewAny', Hit::class);

        $hits = Hit::query()
            ->jsonPaginate($this->paginationNumber());

        return HitResource::collection($hits);
    }

    /**
     * @param HitRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(HitRequest $request)
    {
        $hit = $this->hitService->create($request->validated());

        return $this->json(new HitResource($hit), Response::HTTP_CREATED);
    }

    /**
     * @param Hit $hit
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Hit $hit)
    {
        $this->authorize('view', Hit::class);

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
        $this->authorize('delete', Hit::class);

        $hit->delete();

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
        $this->authorize('delete', Hit::class);

        collect($request->get('items'))->each(function ($hit) {
            if ($hitToDelete = Hit::find($hit['id'])) {
                $hitToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
