<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\ContainerRequest;
use App\Http\Resources\ContainerResource;
use App\Models\Container;
use App\Services\Models\ContainerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ContainersController extends Controller
{

    /**
     * @var ContainerService
     */
    protected $containerService;

    /**
     * ContainersController constructor.
     *
     * @param ContainerService $containerService
     */
    public function __construct(ContainerService $containerService)
    {
        $this->containerService = $containerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Container::class);

        $containers = Container::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(ContainerResource::collection($containers), Response::HTTP_OK);
    }

    /**
     * Display a paginated listing of the resource.
     *
     * @param Request $request
     *
     * @return AnonymousResourceCollection;
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Container::class);

        $containers = Container::query()
            ->withRelations($request)
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return ContainerResource::collection($containers);
    }

    /**
     * @param ContainerRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(ContainerRequest $request)
    {
        $container = $this->containerService->create($request->validated());

        $container->load($container->relationships);

        return $this->json(new ContainerResource($container), Response::HTTP_CREATED);
    }

    /**
     * @param Container $container
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Container $container)
    {
        $this->authorize('view', Container::class);

        $container->load($container->relationships);

        return $this->json(new ContainerResource($container), Response::HTTP_OK);
    }

    /**
     * @param ContainerRequest $request
     * @param Container $container
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(ContainerRequest $request, Container $container)
    {
        $container = $this->containerService->update($container, $request->validated());

        $container->load($container->relationships);

        return $this->json(new ContainerResource($container), Response::HTTP_OK);
    }

    /**
     * @param Container $container
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Container $container)
    {
        $this->authorize('delete', Container::class);

        $container->delete();

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
        $this->authorize('delete', Container::class);

        collect($request->get('items'))->each(function ($container) {
            if ($containerToDelete = Container::find($container['id'])) {
                $containerToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
