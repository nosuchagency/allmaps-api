<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeaconRequest;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Resources\BeaconResource;
use App\Models\Beacon;
use App\Services\Models\BeaconService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BeaconsController extends Controller
{

    /**
     * @var BeaconService
     */
    protected $beaconService;

    /**
     * BeaconsController constructor.
     *
     * @param BeaconService $beaconService
     */
    public function __construct(BeaconService $beaconService)
    {
        $this->middleware('permission:beacons.create')->only(['store']);
        $this->middleware('permission:beacons.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:beacons.update')->only(['update']);
        $this->middleware('permission:beacons.delete')->only(['destroy', 'bulkDestroy']);

        $this->beaconService = $beaconService;
    }

    /**
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $beacons = Beacon::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(BeaconResource::collection($beacons), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $beacons = Beacon::query()
            ->withRelations($request)
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return BeaconResource::collection($beacons);
    }

    /**
     * @param BeaconRequest $request
     *
     * @return JsonResponse
     */
    public function store(BeaconRequest $request)
    {
        $beacon = $this->beaconService->create($request);

        $beacon->load($beacon->relationships);

        return $this->json(new BeaconResource($beacon), Response::HTTP_CREATED);
    }

    /**
     * @param Beacon $beacon
     *
     * @return JsonResponse
     */
    public function show(Beacon $beacon)
    {
        $beacon->load($beacon->relationships);

        return $this->json(new BeaconResource($beacon), Response::HTTP_OK);
    }

    /**
     * @param BeaconRequest $request
     * @param Beacon $beacon
     *
     * @return JsonResponse
     */
    public function update(BeaconRequest $request, Beacon $beacon)
    {
        $beacon = $this->beaconService->update($beacon, $request);

        $beacon->load($beacon->relationships);

        return $this->json(new BeaconResource($beacon), Response::HTTP_OK);
    }

    /**
     * @param Beacon $beacon
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Beacon $beacon)
    {
        $beacon->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($beacon) {
            if ($beaconToDelete = Beacon::find($beacon['id'])) {
                $beaconToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
