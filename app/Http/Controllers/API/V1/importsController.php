<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\ImportResource;
use App\Models\Activity;
use App\Models\Import;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ImportsController extends Controller
{

    /**
     * ImportsController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:imports.read')->only(['index', 'paginated', 'show']);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $imports = Import::query()
            ->filter($request)
            ->get();

        return $this->json(ImportResource::collection($imports), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $imports = Import::query()
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return ImportResource::collection($imports);
    }

    /**
     * @param Import $import
     *
     * @return JsonResponse
     */
    public function show(Import $import)
    {
        return $this->json(new ImportResource($import), Response::HTTP_OK);
    }
}
