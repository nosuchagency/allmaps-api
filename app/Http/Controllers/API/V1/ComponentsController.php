<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\ComponentRequest;
use App\Http\Resources\ComponentResource;
use App\Models\Component;
use App\Services\Models\ComponentService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ComponentsController extends Controller
{

    /**
     * @var ComponentService
     */
    protected $componentService;

    /**
     * ComponentsController constructor.
     *
     * @param ComponentService $componentService
     */
    public function __construct(ComponentService $componentService)
    {
        $this->componentService = $componentService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Component::class);

        $components = Component::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(ComponentResource::collection($components), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Component::class);

        $components = Component::query()
            ->withRelations($request)
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return ComponentResource::collection($components);
    }

    /**
     * @param ComponentRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(ComponentRequest $request)
    {
        $component = $this->componentService->create($request->validated());

        $component->load($component->relationships);

        return $this->json(new ComponentResource($component), Response::HTTP_CREATED);
    }

    /**
     * @param Component $component
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Component $component)
    {
        $this->authorize('view', Component::class);

        $component->load($component->relationships);

        return $this->json(new ComponentResource($component), Response::HTTP_OK);
    }

    /**
     * @param ComponentRequest $request
     * @param Component $component
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(ComponentRequest $request, Component $component)
    {
        $component = $this->componentService->update($component, $request->validated());

        $component->load($component->relationships);

        return $this->json(new ComponentResource($component), Response::HTTP_OK);
    }

    /**
     * @param Component $component
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Component $component)
    {
        $this->authorize('delete', Component::class);

        $component->delete();

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
        $this->authorize('delete', Component::class);

        collect($request->get('items'))->each(function ($component) {
            if ($componentToDelete = Component::find($component['id'])) {
                $componentToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
