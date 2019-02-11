<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\FloorRequest;
use App\Http\Resources\FloorResource;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FloorsController extends Controller
{

    /**
     * FloorsController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:floors.create')->only(['store']);
        $this->middleware('permission:floors.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:floors.update')->only(['update']);
        $this->middleware('permission:floors.delete')->only(['destroy', 'bulkDestroy']);
    }

    /**
     * @param Request $request
     * @param Place $place
     * @param Building $building
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Place $place, Building $building)
    {
        $floors = Floor::withRelations($request)->get();

        return response()->json(FloorResource::collection($floors), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param Place $place
     * @param Building $building
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request, Place $place, Building $building)
    {
        $floors = Floor::withRelations($request)->filter($request)->paginate($this->paginationNumber());

        return FloorResource::collection($floors);
    }

    /**
     * @param FloorRequest $request
     * @param Place $place
     * @param Building $building
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FloorRequest $request, Place $place, Building $building)
    {
        $floor = $building->floors()->create($request->validated());

        $floor->load($floor->relations);

        return response()->json(new FloorResource($floor), Response::HTTP_CREATED);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Place $place, Building $building, Floor $floor)
    {
        $floor->load($floor->relations);

        return response()->json(new FloorResource($floor), Response::HTTP_OK);
    }

    /**
     * @param FloorRequest $request
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FloorRequest $request, Place $place, Building $building, Floor $floor)
    {
        $floor->fill($request->validated())->save();

        $floor->load($floor->relations);

        return response()->json(new FloorResource($floor), Response::HTTP_OK);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Place $place, Building $building, Floor $floor)
    {
        $floor->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($floor) {
            if ($floorToDelete = Floor::find($floor['id'])) {
                $floorToDelete->delete();
            }
        });

        return response()->json(null, Response::HTTP_OK);
    }
}
