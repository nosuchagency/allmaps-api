<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\FolderRequest;
use App\Http\Resources\FolderResource;
use App\Models\Folder;
use App\Services\Models\FolderService;
use Illuminate\Http\Request;
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
        $this->middleware('permission:folders.create')->only(['store']);
        $this->middleware('permission:folders.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:folders.update')->only(['update']);
        $this->middleware('permission:folders.delete')->only(['destroy', 'bulkDestroy']);

        $this->folderService = $folderService;
    }

    /**
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $folders = Folder::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(FolderResource::collection($folders), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $buildings = Folder::query()
            ->withRelations($request)
            ->filter($request)
            ->paginate($this->paginationNumber());

        return FolderResource::collection($buildings);
    }

    /**
     * @param FolderRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Folder $folder)
    {
        $folder->load($folder->relationships);

        return $this->json(new FolderResource($folder), Response::HTTP_OK);
    }

    /**
     * @param FolderRequest $request
     * @param Folder $folder
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Folder $folder)
    {
        if ($folder->primary) {
            return $this->json(null, Response::HTTP_UNAUTHORIZED);
        }

        $folder->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
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
