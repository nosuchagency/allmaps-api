<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\FloorRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\FloorResource;
use App\Http\Resources\LocationResource;
use App\Models\Floor;
use App\Services\Models\FloorService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FloorsController extends Controller
{

    /**
     * @var FloorService
     */
    protected $floorService;

    /**
     * FloorsController constructor.
     *
     * @param FloorService $floorService
     */
    public function __construct(FloorService $floorService)
    {
        $this->floorService = $floorService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Floor::class);

        $floors = Floor::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(FloorResource::collection($floors), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Floor::class);

        $floors = Floor::query()
            ->withRelations($request)
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return FloorResource::collection($floors);
    }

    /**
     * @param FloorRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(FloorRequest $request)
    {
        $floor = $this->floorService->create($request->validated());

        $floor->load($floor->relationships);

        return $this->json(new FloorResource($floor), Response::HTTP_CREATED);
    }

    /**
     * @param Floor $floor
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Floor $floor)
    {
        $this->authorize('view', Floor::class);

        $floor->load($floor->relationships);

        return $this->json(new FloorResource($floor), Response::HTTP_OK);
    }

    /**
     * @param FloorRequest $request
     * @param Floor $floor
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(FloorRequest $request, Floor $floor)
    {
        $floor = $this->floorService->update($floor, $request->validated());

        $floor->load($floor->relationships);

        return $this->json(new FloorResource($floor), Response::HTTP_OK);
    }

    /**
     * @param Floor $floor
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Floor $floor)
    {
        $this->authorize('delete', Floor::class);

        $floor->delete();

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
        $this->authorize('delete', Floor::class);

        collect($request->get('items'))->each(function ($floor) {
            if ($floorToDelete = Floor::find($floor['id'])) {
                $floorToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param SearchRequest $request
     * @param Floor $floor
     *
     * @return JsonResponse
     */
    public function search(SearchRequest $request, Floor $floor)
    {
        $locations = $this->searchForLocations($request->all(), $floor->locations()->getQuery());

        return $this->json(LocationResource::collection($locations), Response::HTTP_OK);
    }
}
