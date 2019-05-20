<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeaconContainerRequest;
use App\Http\Resources\BeaconContainerResource;
use App\Models\Beacon;
use Illuminate\Http\Response;

class BeaconContainersController extends Controller
{

    /**
     * BeaconsController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:beacons.create', 'permission:containers.create'])->only(['store']);
        $this->middleware(['permission:beacons.read', 'permission:containers.read'])->only(['show']);
        $this->middleware(['permission:beacons.update', 'permission:containers.update'])->only(['update']);
        $this->middleware(['permission:beacons.delete', 'permission:containers.delete'])->only(['destroy']);
    }

    /**
     * @param Beacon $beacon
     * @param $containerId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Beacon $beacon, $containerId)
    {
        $beacon->containers()->attach($containerId);

        $container = $beacon->containers()->find($containerId);

        return $this->json(new BeaconContainerResource($container), Response::HTTP_OK);
    }

    /**
     * @param Beacon $beacon
     * @param $containerId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Beacon $beacon, $containerId)
    {
        $container = $beacon->containers()->findOrFail($containerId);

        return $this->json(new BeaconContainerResource($container), Response::HTTP_OK);
    }

    /**
     *
     * @param BeaconContainerRequest $request
     * @param Beacon $beacon
     * @param $containerId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BeaconContainerRequest $request, Beacon $beacon, $containerId)
    {
        $container = $beacon->containers()->findOrFail($containerId);

        $containerId = $request->input('container.id');

        $container->pivot->container_id = $containerId;
        $container->pivot->save();

        $container = $beacon->containers()->find($containerId);

        return $this->json(new BeaconContainerResource($container), Response::HTTP_OK);
    }

    /**
     * @param Beacon $beacon
     * @param $containerId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Beacon $beacon, $containerId)
    {
        $beacon->containers()->detach($containerId);

        return $this->json(null, Response::HTTP_OK);
    }
}
