<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContainerLocationDeleteRequest;
use App\Models\Container;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ContainerLocationsController extends Controller
{

    /**
     * ContainersController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:containers.delete')->only(['destroy']);
    }

    /**
     * @param ContainerLocationDeleteRequest $request
     * @param Container $container
     *
     * @return JsonResponse
     */
    public function destroy(ContainerLocationDeleteRequest $request, Container $container)
    {
        collect($request->get('data'))->each(function ($item) use ($container) {
            $container
                ->locations()
                ->find($item['id'])
                ->dissociateFromContainer();
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
