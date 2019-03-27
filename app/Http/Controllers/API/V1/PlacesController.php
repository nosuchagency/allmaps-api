<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\PlaceRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\MapLocationResource;
use App\Http\Resources\PlaceResource;
use App\Models\Place;
use App\Services\PlaceService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlacesController extends BaseController
{

    /**
     * @var PlaceService
     */
    protected $placeService;

    /**
     * PlacesController constructor.
     *
     * @param PlaceService $placeService
     */
    public function __construct(PlaceService $placeService)
    {
        $this->middleware('permission:places.create')->only(['store']);
        $this->middleware('permission:places.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:places.update')->only(['update']);
        $this->middleware('permission:places.delete')->only(['destroy', 'bulkDestroy']);

        $this->placeService = $placeService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $places = Place::withRelations($request)->get();

        return response()->json(PlaceResource::collection($places), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $places = Place::withRelations($request)->filter($request)->paginate($this->paginationNumber());

        return PlaceResource::collection($places);
    }

    /**
     * @param PlaceRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PlaceRequest $request)
    {
        $place = $this->placeService->create($request);

        $place->load($place->relationships);

        return response()->json(new PlaceResource($place), Response::HTTP_CREATED);
    }

    /**
     * @param Place $place
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Place $place)
    {
        $place->load($place->relationships);

        return response()->json(new PlaceResource($place), Response::HTTP_OK);
    }

    /**
     * @param Place $place
     * @param PlaceRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Place $place, PlaceRequest $request)
    {
        $place = $this->placeService->update($request, $place);

        $place->load($place->relationships);

        return response()->json(new PlaceResource($place), Response::HTTP_OK);
    }

    /**
     * @param Place $place
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Place $place)
    {
        $place->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($place) {
            if ($placeToDelete = Place::find($place['id'])) {
                $placeToDelete->delete();
            }
        });

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param SearchRequest $request
     * @param Place $place
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(SearchRequest $request, Place $place)
    {
        $locations = $this->searchForLocations($request->all(), $place->locations()->getQuery());

        return response()->json(MapLocationResource::collection($locations), Response::HTTP_OK);
    }
}
