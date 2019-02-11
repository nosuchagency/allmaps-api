<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateFloorMapRequest;
use App\Http\Resources\FloorResource;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FloorPlansController extends Controller
{
    /**
     * FloorsController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:floors.read')->only(['show']);
        $this->middleware('permission:floors.update')->only(['update']);
    }


    /**
     * @param Request $request
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Place $place, Building $building, Floor $floor)
    {
        return response()->json(new FloorResource($floor), Response::HTTP_OK);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     * @param UpdateFloorMapRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Place $place, Building $building, Floor $floor, UpdateFloorMapRequest $request)
    {
        $floor->floor_plan = json_encode($request->get('map'));
        $floor->save();

        return response()->json(new FloorResource($floor), Response::HTTP_OK);
    }
}
