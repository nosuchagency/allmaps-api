<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContainerBeaconRequest;
use App\Http\Resources\ContainerBeaconResource;
use App\Models\Beacon;
use App\Models\Container;
use Illuminate\Http\Response;

class ContainerBeaconsController extends Controller
{

    /**
     * BeaconsController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:containers.create')->only(['store']);
        $this->middleware('permission:containers.read')->only(['show']);
        $this->middleware('permission:containers.update')->only(['update']);
        $this->middleware('permission:containers.delete')->only(['destroy']);
    }

    /**
     * @param Container $container
     * @param Beacon $beacon
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Container $container, Beacon $beacon)
    {
        $container->beacons()->attach($beacon);

        $beacon = $container->beacons()->find($beacon->id);

        return response()->json(new ContainerBeaconResource($beacon), Response::HTTP_OK);
    }

    /**
     * @param Container $container
     * @param Beacon $beacon
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Container $container, Beacon $beacon)
    {
        $beacon = $container->beacons()->findOrFail($beacon->id);

        return response()->json(new ContainerBeaconResource($beacon), Response::HTTP_OK);
    }

    /**
     * @param ContainerBeaconRequest $request
     * @param Container $container
     * @param Beacon $beacon
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContainerBeaconRequest $request, Container $container, Beacon $beacon)
    {
        $beacon = $container->beacons()->findOrFail($beacon->id);

        $beaconId = $request->input('beacon.id');

        $beacon->pivot->beacon_id = $request->input('beacon.id');
        $beacon->pivot->save();

        $beacon = $container->beacons()->find($beaconId);

        return response()->json(new ContainerBeaconResource($beacon), Response::HTTP_OK);
    }

    /**
     * @param Container $container
     * @param Beacon $beacon
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Container $container, Beacon $beacon)
    {
        $container->beacons()->detach($beacon);

        return response()->json(null, Response::HTTP_OK);
    }
}
