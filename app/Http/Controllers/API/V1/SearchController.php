<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\LocationResource;
use Illuminate\Http\Response;

class SearchController extends Controller
{

    /**
     * @param SearchRequest $request
     *
     * @return Response
     */
    public function __invoke(SearchRequest $request)
    {
        $locations = $this->searchForLocations($request->all());

        return $this->json(LocationResource::collection($locations), Response::HTTP_OK);
    }
}
