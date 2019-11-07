<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContainerBeaconRequest;
use App\Http\Resources\ContainerBeaconResource;
use App\Models\Container;
use App\Pivots\BeaconContainer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ContainerBeaconsController extends Controller
{

    /**
     * @param Container $container
     * @param $beaconId
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(Container $container, $beaconId)
    {
        $this->authorize('create', BeaconContainer::class);

        $container->beacons()->attach($beaconId);

        $beacon = $container->beacons()->find($beaconId);

        return $this->json(new ContainerBeaconResource($beacon), Response::HTTP_OK);
    }

    /**
     * @param Container $container
     * @param $beaconId
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Container $container, $beaconId)
    {
        $this->authorize('view', BeaconContainer::class);

        $beacon = $container->beacons()->findOrFail($beaconId);

        return $this->json(new ContainerBeaconResource($beacon), Response::HTTP_OK);
    }

    /**
     * @param ContainerBeaconRequest $request
     * @param Container $container
     * @param $beaconId
     *
     * @return JsonResponse
     * @throws Exception
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
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Container $container, $beaconId)
    {
        $this->authorize('delete', BeaconContainer::class);

        $container->beacons()->detach($beaconId);

        return $this->json(null, Response::HTTP_OK);
    }
}
