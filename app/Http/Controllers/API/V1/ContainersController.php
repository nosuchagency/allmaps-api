<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\ContainerRequest;
use App\Http\Resources\ContainerResource;
use App\Models\Container;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContainersController extends Controller
{

    /**
     * ContainersController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:containers.create')->only(['store']);
        $this->middleware('permission:containers.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:containers.update')->only(['update']);
        $this->middleware('permission:containers.delete')->only(['destroy', 'bulkDestroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $containers = Container::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return response()->json(ContainerResource::collection($containers), Response::HTTP_OK);
    }

    /**
     * Display a paginated listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
     */
    public function paginated(Request $request)
    {
        $containers = Container::query()
            ->withRelations($request)
            ->filter($request)
            ->paginate($this->paginationNumber());

        return ContainerResource::collection($containers);
    }

    /**
     * @param ContainerRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ContainerRequest $request)
    {
        $container = Container::create($request->validated());

        foreach ($request->get('tags', []) as $tag) {
            $container->tags()->attach(Tag::find($tag['id']));
        }

        $container->load($container->relationships);

        return response()->json(new ContainerResource($container), Response::HTTP_CREATED);
    }

    /**
     * @param Container $container
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Container $container)
    {
        $container->load($container->relationships);

        return response()->json(new ContainerResource($container), Response::HTTP_OK);
    }

    /**
     * @param ContainerRequest $request
     * @param Container $container
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContainerRequest $request, Container $container)
    {
        $container->fill($request->validated())->save();

        $container->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $container->tags()->attach(Tag::find($tag['id']));
        }

        $container->load($container->relationships);

        return response()->json(new ContainerResource($container), Response::HTTP_OK);
    }

    /**
     * @param Container $container
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Container $container)
    {
        $container->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($container) {
            if ($containerToDelete = Container::find($container['id'])) {
                $containerToDelete->delete();
            }
        });

        return response()->json(null, Response::HTTP_OK);
    }
}
