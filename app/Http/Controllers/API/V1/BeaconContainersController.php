<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeaconContainerRequest;
use App\Http\Resources\BeaconContainerResource;
use App\Models\Beacon;
use App\Models\Container;
use Illuminate\Http\Response;

class BeaconContainersController extends Controller
{

    /**
     * BeaconsController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:beacons.create')->only(['store']);
        $this->middleware('permission:beacons.read')->only(['show']);
        $this->middleware('permission:beacons.update')->only(['update']);
        $this->middleware('permission:beacons.delete')->only(['destroy']);
    }

    /**
     * @param Beacon $beacon
     * @param Container $container
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Beacon $beacon, Container $container)
    {
        $beacon->containers()->attach($container);

        $container = $beacon->containers()->find($container->id);

        return response()->json(new BeaconContainerResource($container), Response::HTTP_CREATED);
    }

    /**
     * @param Beacon $beacon
     * @param Container $container
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Beacon $beacon, Container $container)
    {
        $container = $beacon->containers()->findOrFail($container->id);

        return response()->json(new BeaconContainerResource($container), Response::HTTP_OK);
    }

    /**
     *
     * @param BeaconContainerRequest $request
     * @param Beacon $beacon
     * @param Container $container
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BeaconContainerRequest $request, Beacon $beacon, Container $container)
    {
        $container = $beacon->containers()->findOrFail($container->id);

        $containerId = $request->input('container.id');

        $container->pivot->container_id = $containerId;
        $container->pivot->save();

        $container = $beacon->containers()->find($containerId);

        return response()->json(new BeaconContainerResource($container), Response::HTTP_OK);
    }

    /**
     * @param Beacon $beacon
     * @param Container $container
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Beacon $beacon, Container $container)
    {
        $beacon->containers()->detach($container);

        return response()->json(null, Response::HTTP_CREATED);
    }
}
