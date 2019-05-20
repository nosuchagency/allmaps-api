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
        $this->middleware(['permission:containers.create', 'permission:beacons.create'])->only(['store']);
        $this->middleware(['permission:containers.read', 'permission:beacons.read'])->only(['show']);
        $this->middleware(['permission:containers.update', 'permission:beacons.update'])->only(['update']);
        $this->middleware(['permission:containers.delete', 'permission:beacons.delete'])->only(['destroy']);
    }

    /**
     * @param Container $container
     * @param $beaconId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Container $container, $beaconId)
    {
        $container->beacons()->attach($beaconId);

        $beacon = $container->beacons()->find($beaconId);

        return $this->json(new ContainerBeaconResource($beacon), Response::HTTP_OK);
    }

    /**
     * @param Container $container
     * @param $beaconId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Container $container, $beaconId)
    {
        $beacon = $container->beacons()->findOrFail($beaconId);

        return $this->json(new ContainerBeaconResource($beacon), Response::HTTP_OK);
    }

    /**
     * @param ContainerBeaconRequest $request
     * @param Container $container
     * @param $beaconId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContainerBeaconRequest $request, Container $container, $beaconId)
    {
        $beacon = $container->beacons()->findOrFail($beaconId);

        $beaconId = $request->input('beacon.id');

        $beacon->pivot->beacon_id = $request->input('beacon.id');
        $beacon->pivot->save();

        $beacon = $container->beacons()->find($beaconId);

        return $this->json(new ContainerBeaconResource($beacon), Response::HTTP_OK);
    }

    /**
     * @param Container $container
     * @param $beaconId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Container $container, $beaconId)
    {
        $container->beacons()->detach($beaconId);

        return $this->json(null, Response::HTTP_OK);
    }
}
