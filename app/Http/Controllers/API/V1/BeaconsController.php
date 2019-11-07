<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeaconRequest;
use App\Http\Requests\BeaconsImportRequest;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Resources\BeaconResource;
use App\Models\Beacon;
use App\Models\BeaconProvider;
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
        $this->beaconService = $beaconService;
    }

    /**
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Beacon::class);

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
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Beacon::class);

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
     * @throws Exception
     */
    public function store(BeaconRequest $request)
    {
        $beacon = $this->beaconService->create($request->validated());

        $beacon->load($beacon->relationships);

        return $this->json(new BeaconResource($beacon), Response::HTTP_CREATED);
    }

    /**
     * @param Beacon $beacon
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Beacon $beacon)
    {
        $this->authorize('view', Beacon::class);

        $beacon->load($beacon->relationships);

        return $this->json(new BeaconResource($beacon), Response::HTTP_OK);
    }

    /**
     * @param BeaconRequest $request
     * @param Beacon $beacon
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(BeaconRequest $request, Beacon $beacon)
    {
        $beacon = $this->beaconService->update($beacon, $request->validated());

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
        $this->authorize('delete', Beacon::class);

        $beacon->delete();

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
        $this->authorize('delete', Beacon::class);

        collect($request->get('items'))->each(function ($beacon) {
            if ($beaconToDelete = Beacon::find($beacon['id'])) {
                $beaconToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }


    /**
     * @param BeaconsImportRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function import(BeaconsImportRequest $request)
    {
        $this->authorize('create', Beacon::class);

        $provider = BeaconProvider::find($request->input('provider.id'));

        $provider->importer()->import(
            $request->get('override'),
            $request->only('description')
        );

        return $this->json(null, Response::HTTP_OK);
    }
}
