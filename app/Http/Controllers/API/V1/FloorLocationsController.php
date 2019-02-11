<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeaconLocationRequest;
use App\Http\Requests\FindableLocationRequest;
use App\Http\Requests\PoiLocationRequest;
use App\Http\Requests\UpdatePoiRequest;
use App\Http\Resources\BeaconLocationResource;
use App\Http\Resources\FindableLocationResource;
use App\Http\Resources\FloorResource;
use App\Http\Resources\PoiLocationResource;
use App\Models\Beacon;
use App\Models\Building;
use App\Models\Floor;
use App\Models\MapLocation;
use App\Models\Place;
use App\Models\Poi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FloorLocationsController extends Controller
{

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Place $place, Building $building, Floor $floor)
    {
        return response()->json(new FloorResource($floor), Response::HTTP_OK);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     * @param PoiLocationRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storePoi(Place $place, Building $building, Floor $floor, PoiLocationRequest $request)
    {
        $poi = Poi::find($request->get('poi_id'));

        $location = new Location();

        if ($poi->type === 'area') {
            $location->area = $request->get('area');
        } else {
            $location->lat = $request->get('lat');
            $location->lng = $request->get('lng');
        }

        $location->floor()->associate($floor);
        $location->poi()->associate($poi);
        $location->save();

        return response()->json([
            'location' => new PoiLocationResource($location)
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     * @param FindableLocationRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeFindable(Place $place, Building $building, Floor $floor, FindableLocationRequest $request)
    {
        $location = $floor->findables()->create($request->validated());

        return response()->json([
            'location' => new FindableLocationResource($location)
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     * @param BeaconLocationRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeBeacon(Place $place, Building $building, Floor $floor, BeaconLocationRequest $request)
    {
        $beacon = Beacon::find($request->get('beacon_id'));
        $beacon->lat = $request->get('lat');
        $beacon->lng = $request->get('lng');
        $beacon->floor()->associate($floor);
        $beacon->save();

        return response()->json([
            'location' => new BeaconLocationResource($beacon)
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     * @param MapLocation $location
     * @param UpdatePoiRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePoi(Place $place, Building $building, Floor $floor, MapLocation $location, UpdatePoiRequest $request)
    {
        $poi = $location->poi;

        if ($poi->type === 'icon') {
            $location->lat = $request->get('lat');
            $location->lng = $request->get('lng');
        } else {
            $location->area = $request->get('area');
        }

        $location->save();

        return response()->json([
            'location' => $location
        ], Response::HTTP_OK);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     * @param MapLocation $location
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateFindable(Place $place, Building $building, Floor $floor, MapLocation $location, Request $request)
    {
        $location->lat = $request->get('lat');
        $location->lng = $request->get('lng');
        $location->save();

        return response()->json([
            'location' => $location
        ], Response::HTTP_OK);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     * @param Beacon $beacon
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBeacon(Place $place, Building $building, Floor $floor, Beacon $beacon, Request $request)
    {
        $beacon->lat = $request->get('lat');
        $beacon->lng = $request->get('lng');
        $beacon->save();

        return response()->json([
            'location' => $beacon
        ], Response::HTTP_OK);
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
    public function deletePoi(Place $place, Building $building, Floor $floor, MapLocation $location)
    {
        $location->delete();
        return response()->json(null, Response::HTTP_OK);
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
    public function deleteFindable(Place $place, Building $building, Floor $floor, MapLocation $location)
    {
        $location->delete();
        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     * @param Beacon $beacon
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteBeacon(Place $place, Building $building, Floor $floor, Beacon $beacon)
    {
        $beacon->delete();
        return response()->json(null, Response::HTTP_OK);
    }
}
