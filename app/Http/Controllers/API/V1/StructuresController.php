<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\StructureRequest;
use App\Http\Resources\StructureResource;
use App\Models\Structure;
use App\Services\Models\StructureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class StructuresController extends Controller
{

    /**
     * @var StructureService
     */
    protected $structureService;

    /**
     * StructuresController constructor.
     *
     * @param StructureService $structureService
     */
    public function __construct(StructureService $structureService)
    {
        $this->middleware('permission:floors.create')->only(['store']);
        $this->middleware('permission:floors.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:floors.update')->only(['update']);
        $this->middleware('permission:floors.delete')->only(['destroy', 'bulkDestroy']);

        $this->structureService = $structureService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $structures = Structure::query()
            ->filter($request)
            ->get();

        return $this->json(StructureResource::collection($structures), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $structures = Structure::query()
            ->filter($request)
            ->paginate($this->paginationNumber());

        return StructureResource::collection($structures);
    }

    /**
     * @param StructureRequest $request
     *
     * @return JsonResponse
     */
    public function store(StructureRequest $request)
    {
        $structure = $this->structureService->create($request);

        return $this->json(new StructureResource($structure), Response::HTTP_CREATED);
    }

    /**
     * @param Structure $structure
     *
     * @return JsonResponse
     */
    public function show(Structure $structure)
    {
        return $this->json(new StructureResource($structure), Response::HTTP_OK);
    }

    /**
     * @param StructureRequest $request
     * @param Structure $structure
     *
     * @return JsonResponse
     */
    public function update(StructureRequest $request, Structure $structure)
    {
        $structure = $this->structureService->update($structure, $request);

        return $this->json(new StructureResource($structure), Response::HTTP_OK);
    }

    /**
     * @param Structure $structure
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Structure $structure)
    {
        $structure->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($structure) {
            if ($structureToDelete = Structure::find($structure['id'])) {
                $structureToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
