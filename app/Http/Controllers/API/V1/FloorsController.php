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
use Illuminate\Http\Request;
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
        $this->middleware('permission:floors.create')->only(['store']);
        $this->middleware('permission:floors.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:floors.update')->only(['update']);
        $this->middleware('permission:floors.delete')->only(['destroy', 'bulkDestroy']);

        $this->floorService = $floorService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $floors = Floor::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(FloorResource::collection($floors), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $floors = Floor::query()
            ->withRelations($request)
            ->filter($request)
            ->paginate($this->paginationNumber());

        return FloorResource::collection($floors);
    }

    /**
     * @param FloorRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FloorRequest $request)
    {
        $floor = $this->floorService->create($request);

        $floor->load($floor->relationships);

        return $this->json(new FloorResource($floor), Response::HTTP_CREATED);
    }

    /**
     * @param Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Floor $floor)
    {
        $floor->load($floor->relationships);

        return $this->json(new FloorResource($floor), Response::HTTP_OK);
    }

    /**
     * @param FloorRequest $request
     * @param Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FloorRequest $request, Floor $floor)
    {
        $floor = $this->floorService->update($floor, $request);

        $floor->load($floor->relationships);

        return $this->json(new FloorResource($floor), Response::HTTP_OK);
    }

    /**
     * @param Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Floor $floor)
    {
        $floor->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(SearchRequest $request, Floor $floor)
    {
        $locations = $this->searchForLocations($request->all(), $floor->locations()->getQuery());

        return $this->json(LocationResource::collection($locations), Response::HTTP_OK);
    }
}
