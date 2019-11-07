<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\PlaceRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\LocationResource;
use App\Http\Resources\PlaceResource;
use App\Models\Place;
use App\Services\Models\PlaceService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PlacesController extends Controller
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
        $this->placeService = $placeService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Place::class);

        $places = Place::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(PlaceResource::collection($places), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Place::class);

        $places = Place::query()
            ->withRelations($request)
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return PlaceResource::collection($places);
    }

    /**
     * @param PlaceRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(PlaceRequest $request)
    {
        $place = $this->placeService->create($request);

        $place->load($place->relationships);

        return $this->json(new PlaceResource($place), Response::HTTP_CREATED);
    }

    /**
     * @param Place $place
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Place $place)
    {
        $this->authorize('view', Place::class);

        $place->load($place->relationships);

        return $this->json(new PlaceResource($place), Response::HTTP_OK);
    }

    /**
     * @param Place $place
     * @param PlaceRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Place $place, PlaceRequest $request)
    {
        $place = $this->placeService->update($place, $request);

        $place->load($place->relationships);

        return $this->json(new PlaceResource($place), Response::HTTP_OK);
    }

    /**
     * @param Place $place
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Place $place)
    {
        $this->authorize('delete', Place::class);

        $place->delete();

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
        $this->authorize('delete', Place::class);

        collect($request->get('items'))->each(function ($place) {
            if ($placeToDelete = Place::find($place['id'])) {
                $placeToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param SearchRequest $request
     * @param Place $place
     *
     * @return JsonResponse
     */
    public function search(SearchRequest $request, Place $place)
    {
        $locations = $this->searchForLocations($request->all(), $place->locations()->getQuery());

        return $this->json(LocationResource::collection($locations), Response::HTTP_OK);
    }
}
