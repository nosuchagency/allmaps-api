<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Floor;
use App\Models\MapLocation;
use Illuminate\Http\Response;
use App\Services\MapLocationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MapLocationRequest;
use App\Http\Resources\MapLocationResource;

class MapLocationsController extends Controller
{

    /**
     * @var MapLocationService
     */
    protected $mapLocationService;

    /**
     * MapLocationsController constructor.
     *
     * @param MapLocationService $mapLocationService
     */
    public function __construct(MapLocationService $mapLocationService)
    {
        $this->middleware('permission:floors.create')->only(['store']);
        $this->middleware('permission:floors.read')->only(['index']);
        $this->middleware('permission:floors.update')->only(['update']);
        $this->middleware('permission:floors.delete')->only(['destroy',]);

        $this->mapLocationService = $mapLocationService;
    }

    /**
     * @param $placeId
     * @param $buildingId
     * @param Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($placeId, $buildingId, Floor $floor)
    {
        return response()->json(MapLocationResource::collection($floor->locations), Response::HTTP_OK);
    }

    /**
     * @param $placeId
     * @param $buildingId
     * @param $floorId
     * @param MapLocation $location
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($placeId, $buildingId, $floorId, MapLocation $location)
    {
        return response()->json(new MapLocationResource($location), Response::HTTP_OK);
    }

    /**
     * @param MapLocationRequest $request
     * @param $placeId
     * @param $buildingId
     * @param Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MapLocationRequest $request, $placeId, $buildingId, Floor $floor)
    {
        $location = $this->mapLocationService->create($request, $floor);

        return response()->json(new MapLocationResource($location), Response::HTTP_CREATED);
    }

    /**
     * @param MapLocationRequest $request
     * @param $placeId
     * @param $buildingId
     * @param $floorId
     * @param MapLocation $location
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MapLocationRequest $request, $placeId, $buildingId, $floorId, MapLocation $location)
    {
        $location = $this->mapLocationService->update($request, $location);

        return response()->json(new MapLocationResource($location), Response::HTTP_OK);
    }

    /**
     * @param $placeId
     * @param $buildingId
     * @param $floorId
     * @param MapLocation $location
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($placeId, $buildingId, $floorId, MapLocation $location)
    {
        $location->delete();

        return response()->json(null, Response::HTTP_OK);
    }
}
