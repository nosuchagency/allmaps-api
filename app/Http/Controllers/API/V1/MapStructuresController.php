<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\FloorRequest;
use App\Http\Requests\MapStructureRequest;
use App\Http\Resources\FloorResource;
use App\Http\Resources\MapStructureResource;
use App\Models\Building;
use App\Models\Floor;
use App\Models\MapStructure;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MapStructuresController extends Controller
{

    /**
     * MapStructuresController constructor.
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
     * @param Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Place $place, Building $building, Floor $floor)
    {
        $structures = $floor->structures()->withRelations($request)->get();

        return response()->json(MapStructureResource::collection($structures), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request, Place $place, Building $building, Floor $floor)
    {
        $mapStructures = $floor->structures()->withRelations($request)->filter($request)->paginate($this->paginationNumber());

        return MapStructureResource::collection($mapStructures);
    }

    /**
     * @param MapStructureRequest $request
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MapStructureRequest $request, Place $place, Building $building, Floor $floor)
    {
        $structure = $floor->structures()->create($request->validated());

        return response()->json(new MapStructureResource($structure), Response::HTTP_CREATED);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     * @param MapStructure $structure
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Place $place, Building $building, Floor $floor, MapStructure $structure)
    {
        $structure->load($structure->relations);

        return response()->json(new MapStructureResource($structure), Response::HTTP_OK);
    }

    /**
     * @param MapStructureRequest $request
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     * @param MapStructure $structure
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MapStructureRequest $request, Place $place, Building $building, Floor $floor, MapStructure $structure)
    {
        $structure->fill($request->validated())->save();

        return response()->json(new MapStructureResource($structure), Response::HTTP_OK);
    }

    /**
     * @param Place $place
     * @param Building $building
     * @param Floor $floor
     * @param MapStructure $structure
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Place $place, Building $building, Floor $floor, MapStructure $structure)
    {
        $structure->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($structure) {
            if ($structureToDelete = MapStructure::find($structure['id'])) {
                $structureToDelete->delete();
            }
        });

        return response()->json(null, Response::HTTP_OK);
    }
}
