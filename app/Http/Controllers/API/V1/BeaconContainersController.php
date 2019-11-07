<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeaconContainerRequest;
use App\Http\Resources\BeaconContainerResource;
use App\Models\Beacon;
use App\Models\Container;
use App\Pivots\BeaconContainer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BeaconContainersController extends Controller
{

    /**
     * @param Beacon $beacon
     * @param $containerId
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(Beacon $beacon, $containerId)
    {
        $this->authorize('create', BeaconContainer::class);

        $beacon->containers()->attach($containerId);

        $container = $beacon->containers()->find($containerId);

        return $this->json(new BeaconContainerResource($container), Response::HTTP_OK);
    }

    /**
     * @param Beacon $beacon
     * @param $containerId
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Beacon $beacon, $containerId)
    {
        $this->authorize('view', BeaconContainer::class);

        $container = $beacon->containers()->findOrFail($containerId);

        return $this->json(new BeaconContainerResource($container), Response::HTTP_OK);
    }

    /**
     *
     * @param BeaconContainerRequest $request
     * @param Beacon $beacon
     * @param $containerId
     *
     * @return JsonResponse
     * @throws Exception
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
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Beacon $beacon, $containerId)
    {
        $this->authorize('delete', BeaconContainer::class);

        $beacon->containers()->detach($containerId);

        return $this->json(null, Response::HTTP_OK);
    }
}
