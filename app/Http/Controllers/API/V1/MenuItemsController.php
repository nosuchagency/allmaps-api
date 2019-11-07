<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\MenuItemRequest;
use App\Http\Resources\MenuItemResource;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Services\Models\MenuItemService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class MenuItemsController extends Controller
{

    /**
     * @var MenuItemService
     */
    protected $menuItemService;

    /**
     * MenuItemsController constructor.
     *
     * @param MenuItemService $menuItemService
     */
    public function __construct(MenuItemService $menuItemService)
    {
        $this->menuItemService = $menuItemService;
    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function index()
    {
        $this->authorize('viewAny', MenuItem::class);

        $menuItems = MenuItem::all();

        return $this->json(MenuItemResource::collection($menuItems), Response::HTTP_OK);
    }

    /**
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated()
    {
        $this->authorize('viewAny', MenuItem::class);

        $menuItems = MenuItem::query()
            ->jsonPaginate($this->paginationNumber());

        return MenuItemResource::collection($menuItems);
    }

    /**
     * @param MenuItemRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(MenuItemRequest $request)
    {
        $menuItem = $this->menuItemService->create($request);

        return $this->json(new MenuItemResource($menuItem), Response::HTTP_CREATED);
    }

    /**
     * @param MenuItem $menuItem
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(MenuItem $menuItem)
    {
        $this->authorize('view', MenuItem::class);

        return $this->json(new MenuItemResource($menuItem), Response::HTTP_OK);
    }

    /**
     * @param MenuItemRequest $request
     * @param MenuItem $menuItem
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(MenuItemRequest $request, MenuItem $menuItem)
    {
        $menuItem = $this->menuItemService->update($menuItem, $request);

        return $this->json(new MenuItemResource($menuItem), Response::HTTP_OK);
    }

    /**
     * @param MenuItem $menuItem
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(MenuItem $menuItem)
    {
        $this->authorize('delete', MenuItem::class);

        $menuItem->delete();

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
        $this->authorize('delete', MenuItem::class);

        collect($request->get('items'))->each(function ($menuItem) {
            if ($menuItemToDelete = MenuItem::find($menuItem['id'])) {
                $menuItemToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
