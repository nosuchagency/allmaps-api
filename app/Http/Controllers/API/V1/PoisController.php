<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\PoiRequest;
use App\Http\Resources\PoiResource;
use App\Models\Poi;
use App\Services\Models\PoiService;
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
        $this->middleware('permission:pois.create')->only(['store']);
        $this->middleware('permission:pois.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:pois.update')->only(['update']);
        $this->middleware('permission:pois.delete')->only(['destroy', 'bulkDestroy']);

        $this->poiService = $poiService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
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
     */
    public function paginated(Request $request)
    {
        $pois = Poi::query()
            ->withRelations($request)
            ->filter($request)
            ->paginate($this->paginationNumber());

        return PoiResource::collection($pois);
    }

    /**
     * @param PoiRequest $request
     *
     * @return JsonResponse
     */
    public function store(PoiRequest $request)
    {
        $poi = $this->poiService->create($request);

        $poi->load($poi->relationships);

        return $this->json(new PoiResource($poi), Response::HTTP_CREATED);
    }

    /**
     * @param Poi $poi
     *
     * @return JsonResponse
     */
    public function show(Poi $poi)
    {
        $poi->load($poi->relationships);

        return $this->json(new PoiResource($poi), Response::HTTP_OK);
    }

    /**
     * @param PoiRequest $request
     * @param Poi $poi
     *
     * @return JsonResponse
     */
    public function update(PoiRequest $request, Poi $poi)
    {
        $poi = $this->poiService->update($poi, $request);

        $poi->load($poi->relationships);

        return $this->json(new PoiResource($poi), Response::HTTP_OK);
    }

    /**
     * @param Poi $poi
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Poi $poi)
    {
        $poi->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($poi) {
            if ($poiToDelete = Poi::find($poi['id'])) {
                $poiToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
