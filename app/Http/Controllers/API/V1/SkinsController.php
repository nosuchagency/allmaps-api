<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\SkinRequest;
use App\Http\Resources\SkinResource;
use App\Models\Skin;
use App\Services\Models\SkinService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class SkinsController extends Controller
{
    /**
     * @var SkinService
     */
    protected $skinService;

    /**
     * SkinsController constructor.
     *
     * @param SkinService $skinService
     */
    public function __construct(SkinService $skinService)
    {
        $this->middleware('permission:skins.create')->only(['store']);
        $this->middleware('permission:skins.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:skins.update')->only(['update']);
        $this->middleware('permission:skins.delete')->only(['destroy', 'bulkDestroy']);

        $this->skinService = $skinService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $skins = Skin::query()
            ->filter($request)
            ->get();

        return $this->json(SkinResource::collection($skins), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $skins = Skin::query()
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return SkinResource::collection($skins);
    }


    /**
     * @param SkinRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(SkinRequest $request)
    {
        $skin = $this->skinService->create($request);

        return $this->json(new SkinResource($skin), Response::HTTP_CREATED);
    }

    /**
     * @param Skin $skin
     *
     * @return JsonResponse
     */
    public function show(Skin $skin)
    {
        return $this->json(new SkinResource($skin), Response::HTTP_OK);
    }


    /**
     * @param SkinRequest $request
     * @param Skin $skin
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(SkinRequest $request, Skin $skin)
    {
        $skin = $this->skinService->update($skin, $request);

        return $this->json(new SkinResource($skin), Response::HTTP_OK);
    }

    /**
     * @param Skin $skin
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Skin $skin)
    {
        $skin->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($skin) {
            if ($skinToDelete = Skin::find($skin['id'])) {
                $skinToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
