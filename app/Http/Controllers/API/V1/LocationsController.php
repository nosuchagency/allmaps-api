<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\BulkDeleteRequest;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use App\Services\Models\LocationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Http\Resources\LocationResource;

class LocationsController extends Controller
{

    /**
     * @var LocationService
     */
    protected $locationService;

    /**
     * LocationsController constructor.
     *
     * @param LocationService $locationService
     */
    public function __construct(LocationService $locationService)
    {
        $this->middleware('permission:floors.create')->only(['store']);
        $this->middleware('permission:floors.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:floors.update')->only(['update']);
        $this->middleware('permission:floors.delete')->only(['destroy', 'bulkDestroy']);

        $this->locationService = $locationService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $locations = Location::query()
            ->filter($request)
            ->get();

        return $this->json(LocationResource::collection($locations), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $locations = Location::query()
            ->filter($request)
            ->paginate($this->paginationNumber());

        return LocationResource::collection($locations);
    }

    /**
     * @param LocationRequest $request
     *
     * @return JsonResponse
     */
    public function store(LocationRequest $request)
    {
        $location = $this->locationService->create($request);

        return $this->json(new LocationResource($location), Response::HTTP_CREATED);
    }

    /**
     * @param Location $location
     *
     * @return JsonResponse
     */
    public function show(Location $location)
    {
        return $this->json(new LocationResource($location), Response::HTTP_OK);
    }

    /**
     * @param LocationRequest $request
     * @param Location $location
     *
     * @return JsonResponse
     */
    public function update(LocationRequest $request, Location $location)
    {
        $location = $this->locationService->update($location, $request);

        return $this->json(new LocationResource($location), Response::HTTP_OK);
    }

    /**
     * @param Location $location
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($location) {
            if ($locationToDelete = Location::find($location['id'])) {
                $locationToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
