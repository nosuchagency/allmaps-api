<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\BulkDeleteRequest;
use App\Models\Location;
use Exception;
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
        $this->locationService = $locationService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Location::class);

        $locations = Location::query()
            ->filter($request)
            ->get();

        return $this->json(LocationResource::collection($locations), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Location::class);

        $locations = Location::query()
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return LocationResource::collection($locations);
    }

    /**
     * @param LocationRequest $request
     *
     * @return JsonResponse
     * @throws Exception
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
     * @throws Exception
     */
    public function show(Location $location)
    {
        $this->authorize('view', Location::class);

        return $this->json(new LocationResource($location), Response::HTTP_OK);
    }

    /**
     * @param LocationRequest $request
     * @param Location $location
     *
     * @return JsonResponse
     * @throws Exception
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
     * @throws Exception
     */
    public function destroy(Location $location)
    {
        $this->authorize('delete', Location::class);

        $location->delete();

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
        $this->authorize('delete', Location::class);

        collect($request->get('items'))->each(function ($location) {
            if ($locationToDelete = Location::find($location['id'])) {
                $locationToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
