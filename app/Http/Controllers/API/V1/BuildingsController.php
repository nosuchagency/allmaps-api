<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuildingRequest;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Resources\BuildingResource;
use App\Models\Building;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BuildingsController extends Controller
{

    /**
     * BuildingsController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:buildings.create')->only(['store']);
        $this->middleware('permission:buildings.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:buildings.update')->only(['update']);
        $this->middleware('permission:buildings.delete')->only(['destroy', 'bulkDestroy']);
    }

    /**
     *
     * @param Request $request
     * @param Place $place
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Place $place)
    {
        $buildings = Building::withRelations($request)->get();

        return response()->json(BuildingResource::collection($buildings), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param Place $place
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request, Place $place)
    {
        $buildings = Building::withRelations($request)->filter($request)->paginate($this->paginationNumber());

        return BuildingResource::collection($buildings);
    }

    /**
     * @param BuildingRequest $request
     * @param Place $place
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BuildingRequest $request, Place $place)
    {
        $building = $place->buildings()->create($request->validated());
        $building->addAndSaveImage($request->get('image'));

        $building->load($building->relations);

        return response()->json(new BuildingResource($building), Response::HTTP_CREATED);
    }

    /**
     * @param Place $place
     * @param Building $building
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Place $place, Building $building)
    {
        $building->load($building->relations);

        return response()->json(new BuildingResource($building), Response::HTTP_OK);
    }

    /**
     * @param BuildingRequest $request
     * @param Place $place
     * @param Building $building
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BuildingRequest $request, Place $place, Building $building)
    {
        $building->fill($request->validated())->save();
        $building->addAndSaveImage($request->get('image'));

        $building->load($building->relations);

        return response()->json(new BuildingResource($building), Response::HTTP_OK);
    }

    /**
     * @param Place $place
     * @param Building $building
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Place $place, Building $building)
    {
        $building->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($building) {
            if ($buildingToDelete = Building::find($building['id'])) {
                $buildingToDelete->delete();
            }
        });

        return response()->json(null, Response::HTTP_OK);
    }
}
