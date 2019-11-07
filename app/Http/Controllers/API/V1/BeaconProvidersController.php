<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeaconProviderRequest;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Resources\BeaconProviderResource;
use App\Models\BeaconProvider;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class BeaconProvidersController extends Controller
{

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function index()
    {
        $this->authorize('viewAny', BeaconProvider::class);

        $providers = BeaconProvider::all();

        return $this->json(BeaconProviderResource::collection($providers), Response::HTTP_OK);
    }

    /**
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated()
    {
        $this->authorize('viewAny', BeaconProvider::class);

        $providers = BeaconProvider::query()
            ->jsonPaginate($this->paginationNumber());

        return BeaconProviderResource::collection($providers);
    }

    /**
     * @param BeaconProviderRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(BeaconProviderRequest $request)
    {
        $provider = BeaconProvider::create([
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'meta' => $request->get('meta')
        ]);

        if (!$provider->client()->valid()) {
            $provider->delete();

            throw ValidationException::withMessages([
                'meta' => ['The given credentials are invalid.'],
            ]);
        }

        return $this->json(new BeaconProviderResource($provider), Response::HTTP_CREATED);
    }

    /**
     * @param BeaconProvider $provider
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(BeaconProvider $provider)
    {
        $this->authorize('view', BeaconProvider::class);

        return $this->json(new BeaconProviderResource($provider), Response::HTTP_OK);
    }

    /**
     * @param BeaconProviderRequest $request
     * @param BeaconProvider $provider
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(BeaconProviderRequest $request, BeaconProvider $provider)
    {
        $provider->fill($request->validated())->save();

        return $this->json(new BeaconProviderResource($provider), Response::HTTP_OK);
    }

    /**
     * @param BeaconProvider $provider
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(BeaconProvider $provider)
    {
        $this->authorize('delete', BeaconProvider::class);

        $provider->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        $this->authorize('delete', BeaconProvider::class);

        collect($request->get('items'))->each(function ($provider) {
            if ($providerToDelete = BeaconProvider::find($provider['id'])) {
                $providerToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
