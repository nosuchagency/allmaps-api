<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\FolderRequest;
use App\Http\Resources\FolderResource;
use App\Models\Container;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FoldersController extends Controller
{

    /**
     * FoldersController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:folders.create')->only(['store']);
        $this->middleware('permission:folders.read')->only(['index', 'show']);
        $this->middleware('permission:folders.update')->only(['update']);
        $this->middleware('permission:folders.delete')->only(['destroy', 'bulkDestroy']);
    }

    /**
     *
     * @param Request $request
     * @param Container $container
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Container $container)
    {
        $folders = Folder::withRelations($request)->get();

        return response()->json(FolderResource::collection($folders), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param Container $container
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request, Container $container)
    {
        $buildings = Folder::withRelations($request)->filter($request)->paginate($this->paginationNumber());

        return FolderResource::collection($buildings);
    }

    /**
     * @param FolderRequest $request
     * @param Container $container
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FolderRequest $request, Container $container)
    {
        $folder = $container->folders()->create($request->validated());

        foreach ($request->get('tags') as $tag) {
            $folder->tags()->attach(Tag::find($tag['id']));
        }

        $folder->load($folder->relationships);

        return response()->json(new FolderResource($folder), Response::HTTP_CREATED);
    }

    /**
     * @param Container $container
     * @param Folder $folder
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Container $container, Folder $folder)
    {
        $folder->load($folder->relationships);

        return response()->json(new FolderResource($folder), Response::HTTP_OK);
    }

    /**
     * @param FolderRequest $request
     * @param Container $container
     * @param Folder $folder
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FolderRequest $request, Container $container, Folder $folder)
    {
        $folder->fill($request->validated())->save();

        $folder->tags()->sync([]);

        foreach ($request->get('tags') as $tag) {
            $folder->tags()->attach(Tag::find($tag['id']));
        }

        $folder->load($folder->relationships);

        return response()->json(new FolderResource($folder), Response::HTTP_OK);
    }

    /**
     * @param Container $container
     * @param Folder $folder
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Container $container, Folder $folder)
    {
        if ($folder->primary) {
            return response()->json(null, Response::HTTP_UNAUTHORIZED);
        }

        $folder->delete();

        return response()->json(null, Response::HTTP_OK);
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

        return response()->json(null, Response::HTTP_OK);
    }
}
