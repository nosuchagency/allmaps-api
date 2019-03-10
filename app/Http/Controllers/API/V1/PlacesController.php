<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\PlaceRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\MapLocationResource;
use App\Http\Resources\PlaceResource;
use App\Models\Place;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlacesController extends BaseController
{

    /**
     * PlacesController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:places.create')->only(['store']);
        $this->middleware('permission:places.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:places.update')->only(['update']);
        $this->middleware('permission:places.delete')->only(['destroy', 'bulkDestroy']);
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
        $place = Place::create($request->validated());
        $place->addAndSaveImage($request->get('image'));

        foreach ($request->get('tags') as $tag) {
            $place->tags()->attach(Tag::find($tag['id']));
        }

        $place->load($place->relations);

        return response()->json(new PlaceResource($place), Response::HTTP_CREATED);
    }

    /**
     * @param Place $place
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Place $place)
    {
        $place->load($place->relations);

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
        $place->fill($request->validated())->save();
        $place->addAndSaveImage($request->get('image'));

        $place->tags()->sync([]);

        foreach ($request->get('tags') as $tag) {
            $place->tags()->attach(Tag::find($tag['id']));
        }

        $place->load($place->relations);

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
     * @param Place $place
     * @param SearchRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Place $place, SearchRequest $request)
    {
        $locations = $this->searchForLocations($request->all(), $place->locations()->getQuery());

        return response()->json(MapLocationResource::collection($locations), Response::HTTP_OK);
    }
}
