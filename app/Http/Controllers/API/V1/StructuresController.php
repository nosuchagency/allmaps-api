<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\StructureRequest;
use App\Http\Resources\StructureResource;
use App\Models\Structure;
use App\Services\Models\StructureService;
use Exception;
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
        $this->structureService = $structureService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Structure::class);

        $structures = Structure::query()
            ->filter($request)
            ->get();

        return $this->json(StructureResource::collection($structures), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Structure::class);

        $structures = Structure::query()
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return StructureResource::collection($structures);
    }

    /**
     * @param StructureRequest $request
     *
     * @return JsonResponse
     * @throws Exception
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
     * @throws Exception
     */
    public function show(Structure $structure)
    {
        $this->authorize('view', Structure::class);

        return $this->json(new StructureResource($structure), Response::HTTP_OK);
    }

    /**
     * @param StructureRequest $request
     * @param Structure $structure
     *
     * @return JsonResponse
     * @throws Exception
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
     * @throws Exception
     */
    public function destroy(Structure $structure)
    {
        $this->authorize('delete', Structure::class);

        $structure->delete();

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
        $this->authorize('delete', Structure::class);

        collect($request->get('items'))->each(function ($structure) {
            if ($structureToDelete = Structure::find($structure['id'])) {
                $structureToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
