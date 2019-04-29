<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\LocationResource;
use Illuminate\Http\Response;

class SearchController extends BaseController
{

    /**
     * @param SearchRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(SearchRequest $request)
    {
        $locations = $this->searchForLocations($request->all());

        return response()->json(LocationResource::collection($locations), Response::HTTP_OK);
    }
}
