<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\PoiRequest;
use App\Http\Resources\PoiResource;
use App\Models\Poi;
use App\Services\Models\PoiService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PoisController extends Controller
{

    /**
     * @var PoiService
     */
    protected $poiService;

    /**
     * PoisController constructor.
     *
     * @param PoiService $poiService
     */
    public function __construct(PoiService $poiService)
    {
        $this->poiService = $poiService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Poi::class);

        $pois = Poi::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(PoiResource::collection($pois), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Poi::class);

        $pois = Poi::query()
            ->withRelations($request)
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return PoiResource::collection($pois);
    }

    /**
     * @param PoiRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(PoiRequest $request)
    {
        $poi = $this->poiService->create($request->validated());

        $poi->load($poi->relationships);

        return $this->json(new PoiResource($poi), Response::HTTP_CREATED);
    }

    /**
     * @param Poi $poi
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Poi $poi)
    {
        $this->authorize('view', Poi::class);

        $poi->load($poi->relationships);

        return $this->json(new PoiResource($poi), Response::HTTP_OK);
    }

    /**
     * @param PoiRequest $request
     * @param Poi $poi
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(PoiRequest $request, Poi $poi)
    {
        $poi = $this->poiService->update($poi, $request->validated());

        $poi->load($poi->relationships);

        return $this->json(new PoiResource($poi), Response::HTTP_OK);
    }

    /**
     * @param Poi $poi
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Poi $poi)
    {
        $this->authorize('delete', Poi::class);

        $poi->delete();

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
        $this->authorize('delete', Poi::class);

        collect($request->get('items'))->each(function ($poi) {
            if ($poiToDelete = Poi::find($poi['id'])) {
                $poiToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
