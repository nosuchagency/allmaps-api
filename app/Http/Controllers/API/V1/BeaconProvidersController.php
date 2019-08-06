<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeaconProviderRequest;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Resources\BeaconProviderResource;
use App\Models\BeaconProvider;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class BeaconProvidersController extends Controller
{
    /**
     * BeaconsController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:beacon-providers.create')->only(['store']);
        $this->middleware('permission:beacon-providers.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:beacon-providers.update')->only(['update']);
        $this->middleware('permission:beacon-providers.delete')->only(['destroy', 'bulkDestroy']);
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $providers = BeaconProvider::all();

        return $this->json($providers, Response::HTTP_OK);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function paginated()
    {
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

        return $this->json($provider, Response::HTTP_CREATED);
    }

    /**
     * @param BeaconProvider $provider
     *
     * @return JsonResponse
     */
    public function show(BeaconProvider $provider)
    {
        return $this->json($provider, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param BeaconProvider $provider
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Request $request, BeaconProvider $provider)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $provider->fill([
            'name' => $request->get('name')
        ])->save();

        return $this->json($provider, Response::HTTP_OK);
    }

    /**
     * @param BeaconProvider $provider
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(BeaconProvider $provider)
    {
        $provider->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($provider) {
            if ($providerToDelete = BeaconProvider::find($provider['id'])) {
                $providerToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
