<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImportResource;
use App\Models\Import;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ImportsController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Import::class);

        $imports = Import::query()
            ->filter($request)
            ->get();

        return $this->json(ImportResource::collection($imports), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Import::class);

        $imports = Import::query()
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return ImportResource::collection($imports);
    }

    /**
     * @param Import $import
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Import $import)
    {
        $this->authorize('view', Import::class);

        return $this->json(new ImportResource($import), Response::HTTP_OK);
    }
}
