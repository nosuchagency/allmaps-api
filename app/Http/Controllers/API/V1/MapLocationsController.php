<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MapLocationRequest;
use App\Http\Resources\MapLocationResource;
use App\Models\Building;
use App\Models\Floor;
use App\Models\MapLocation;
use App\Models\Place;
use Illuminate\Http\Response;

class MapLocationsController extends Controller
{

    /**
     * MapLocationsController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:floors.create')->only(['store']);
        $this->middleware('permission:floors.read')->only(['index']);
        $this->middleware('permission:floors.update')->only(['update']);
        $this->middleware('permission:floors.delete')->only(['destroy',]);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Place $place, Building $building, Floor $floor)
    {
        return response()->json(MapLocationResource::collection($floor->locations), Response::HTTP_OK);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     * @param MapLocation $location
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Place $place, Building $building, Floor $floor, MapLocation $location)
    {
        return response()->json(new MapLocationResource($location), Response::HTTP_OK);
    }

    /**
     * @param MapLocationRequest $request
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MapLocationRequest $request, Place $place, Building $building, Floor $floor)
    {
        $location = $floor->locations()->create($request->except('image'));
        $location->addAndSaveImage($request->get('image'));

        return response()->json(new MapLocationResource($location->refresh()), Response::HTTP_CREATED);
    }

    /**
     * @param MapLocationRequest $request
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     * @param MapLocation $location
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MapLocationRequest $request, Place $place, Building $building, Floor $floor, MapLocation $location)
    {
        $location->fill($request->except('image'))->save();
        $location->addAndSaveImage($request->get('image'));

        return response()->json(new MapLocationResource($location), Response::HTTP_OK);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     * @param MapLocation $location
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Place $place, Building $building, Floor $floor, MapLocation $location)
    {
        $location->delete();

        return response()->json(null, Response::HTTP_OK);
    }
}
