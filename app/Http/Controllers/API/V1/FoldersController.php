<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\FolderRequest;
use App\Http\Resources\FolderResource;
use App\Models\Folder;
use App\Services\Models\FolderService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FoldersController extends Controller
{

    /**
     * @var FolderService
     */
    protected $folderService;

    /**
     * FoldersController constructor.
     *
     * @param FolderService $folderService
     */
    public function __construct(FolderService $folderService)
    {
        $this->folderService = $folderService;
    }

    /**
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Folder::class);

        $folders = Folder::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(FolderResource::collection($folders), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Folder::class);

        $buildings = Folder::query()
            ->withRelations($request)
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return FolderResource::collection($buildings);
    }

    /**
     * @param FolderRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(FolderRequest $request)
    {
        $folder = $this->folderService->create($request);

        $folder->load($folder->relationships);

        return $this->json(new FolderResource($folder), Response::HTTP_CREATED);
    }

    /**
     * @param Folder $folder
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Folder $folder)
    {
        $this->authorize('view', Folder::class);

        $folder->load($folder->relationships);

        return $this->json(new FolderResource($folder), Response::HTTP_OK);
    }

    /**
     * @param FolderRequest $request
     * @param Folder $folder
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(FolderRequest $request, Folder $folder)
    {
        $folder = $this->folderService->update($folder, $request);

        $folder->load($folder->relationships);

        return $this->json(new FolderResource($folder), Response::HTTP_OK);
    }

    /**
     * @param Folder $folder
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Folder $folder)
    {
        $this->authorize('delete', Folder::class);

        if ($folder->primary) {
            return $this->json(null, Response::HTTP_UNAUTHORIZED);
        }

        $folder->delete();

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
        $this->authorize('delete', Folder::class);

        collect($request->get('items'))->each(function ($folder) {
            $folderToDelete = Folder::query()
                ->whereId($folder['id'])
                ->wherePrimary(false)
                ->first();

            if ($folderToDelete) {
                $folderToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
