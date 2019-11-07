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
        $this->skinService = $skinService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Skin::class);

        $skins = Skin::query()
            ->filter($request)
            ->get();

        return $this->json(SkinResource::collection($skins), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Skin::class);

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
     * @throws Exception
     */
    public function show(Skin $skin)
    {
        $this->authorize('view', Skin::class);

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
        $this->authorize('delete', Skin::class);

        $skin->delete();

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
        $this->authorize('delete', Skin::class);

        collect($request->get('items'))->each(function ($skin) {
            if ($skinToDelete = Skin::find($skin['id'])) {
                $skinToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
