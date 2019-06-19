<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Container;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @param Container $container
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function destroy(Container $container, Request $request)
    {
        collect($request->get('data'))->each(function ($item) use ($container) {
            $container
                ->locations()
                ->find($item['id'])
                ->container()
                ->dissociate()
                ->save();
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
