<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuildingRequest;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\BuildingResource;
use App\Http\Resources\LocationResource;
use App\Models\Building;
use App\Services\Models\BuildingService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BuildingsController extends Controller
{

    /**
     * @var BuildingService
     */
    protected $buildingService;

    /**
     * BuildingsController constructor.
     *
     * @param BuildingService $buildingService
     */
    public function __construct(BuildingService $buildingService)
    {
        $this->middleware('permission:buildings.create')->only(['store']);
        $this->middleware('permission:buildings.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:buildings.update')->only(['update']);
        $this->middleware('permission:buildings.delete')->only(['destroy', 'bulkDestroy']);

        $this->buildingService = $buildingService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $buildings = Building::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(BuildingResource::collection($buildings), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $buildings = Building::query()
            ->withRelations($request)
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return BuildingResource::collection($buildings);
    }

    /**
     * @param BuildingRequest $request
     *
     * @return JsonResponse
     */
    public function store(BuildingRequest $request)
    {
        $building = $this->buildingService->create($request);

        $building->load($building->relationships);

        return $this->json(new BuildingResource($building), Response::HTTP_CREATED);
    }

    /**
     * @param Building $building
     *
     * @return JsonResponse
     */
    public function show(Building $building)
    {
        $building->load($building->relationships);

        return $this->json(new BuildingResource($building), Response::HTTP_OK);
    }

    /**
     * @param BuildingRequest $request
     * @param Building $building
     *
     * @return JsonResponse
     */
    public function update(BuildingRequest $request, Building $building)
    {
        $building = $this->buildingService->update($building, $request);

        $building->load($building->relationships);

        return $this->json(new BuildingResource($building), Response::HTTP_OK);
    }

    /**
     * @param Building $building
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Building $building)
    {
        $building->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($building) {
            if ($buildingToDelete = Building::find($building['id'])) {
                $buildingToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param SearchRequest $request
     * @param Building $building
     *
     * @return JsonResponse
     */
    public function search(SearchRequest $request, Building $building)
    {
        $locations = $this->searchForLocations($request->all(), $building->locations()->getQuery());

        return $this->json(LocationResource::collection($locations), Response::HTTP_OK);
    }
}
