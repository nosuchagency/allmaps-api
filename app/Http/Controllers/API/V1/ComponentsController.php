<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\ComponentRequest;
use App\Http\Resources\ComponentResource;
use App\Models\Component;
use App\Services\ComponentService;
use Illuminate\Http\Request;
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
        $this->middleware('permission:components.create')->only(['store']);
        $this->middleware('permission:components.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:components.update')->only(['update']);
        $this->middleware('permission:components.delete')->only(['destroy', 'bulkDestroy']);

        $this->componentService = $componentService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $components = Component::withRelations($request)->get();

        return response()->json(ComponentResource::collection($components), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $components = Component::withRelations($request)->filter($request)->paginate($this->paginationNumber());

        return ComponentResource::collection($components);
    }

    /**
     * @param ComponentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ComponentRequest $request)
    {
        $component = $this->componentService->create($request);

        $component->load($component->relationships);

        return response()->json(new ComponentResource($component), Response::HTTP_CREATED);
    }

    /**
     * @param Component $component
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Component $component)
    {
        $component->load($component->relationships);

        return response()->json(new ComponentResource($component), Response::HTTP_OK);
    }

    /**
     * @param ComponentRequest $request
     * @param Component $component
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ComponentRequest $request, Component $component)
    {
        $component = $this->componentService->update($component, $request);

        $component->load($component->relationships);

        return response()->json(new ComponentResource($component), Response::HTTP_OK);
    }

    /**
     * @param Component $component
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Component $component)
    {
        $component->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($component) {
            if ($componentToDelete = Component::find($component['id'])) {
                $componentToDelete->delete();
            }
        });

        return response()->json(null, Response::HTTP_OK);
    }
}
