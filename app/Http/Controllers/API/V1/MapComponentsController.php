<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\MapComponentRequest;
use App\Http\Resources\MapComponentResource;
use App\Models\MapComponent;
use App\Services\MapComponentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MapComponentsController extends Controller
{

    /**
     * @var MapComponentService
     */
    protected $mapComponentService;

    /**
     * MapComponentsController constructor.
     *
     * @param MapComponentService $mapComponentService
     */
    public function __construct(MapComponentService $mapComponentService)
    {
        $this->middleware('permission:map-components.create')->only(['store']);
        $this->middleware('permission:map-components.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:map-components.update')->only(['update']);
        $this->middleware('permission:map-components.delete')->only(['destroy', 'bulkDestroy']);

        $this->mapComponentService = $mapComponentService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $mapComponents = MapComponent::withRelations($request)->get();

        return response()->json(MapComponentResource::collection($mapComponents), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $mapComponents = MapComponent::withRelations($request)->filter($request)->paginate($this->paginationNumber());

        return MapComponentResource::collection($mapComponents);
    }

    /**
     * @param MapComponentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MapComponentRequest $request)
    {
        $mapComponent = $this->mapComponentService->create($request);

        $mapComponent->load($mapComponent->relationships);

        return response()->json(new MapComponentResource($mapComponent), Response::HTTP_CREATED);
    }

    /**
     * @param MapComponent $mapComponent
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MapComponent $mapComponent)
    {
        $mapComponent->load($mapComponent->relationships);

        return response()->json(new MapComponentResource($mapComponent), Response::HTTP_OK);
    }

    /**
     * @param MapComponentRequest $request
     * @param MapComponent $mapComponent
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MapComponentRequest $request, MapComponent $mapComponent)
    {
        $mapComponent = $this->mapComponentService->update($request, $mapComponent);

        $mapComponent->load($mapComponent->relationships);

        return response()->json(new MapComponentResource($mapComponent), Response::HTTP_OK);
    }

    /**
     * @param MapComponent $mapComponent
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(MapComponent $mapComponent)
    {
        $mapComponent->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($mapComponent) {
            if ($mapComponentToDelete = MapComponent::find($mapComponent['id'])) {
                $mapComponentToDelete->delete();
            }
        });

        return response()->json(null, Response::HTTP_OK);
    }
}
