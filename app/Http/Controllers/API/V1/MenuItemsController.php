<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\MenuItemRequest;
use App\Http\Resources\MenuItemResource;
use App\Models\MenuItem;
use App\Services\Models\MenuItemService;
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
        $this->middleware('permission:menus.create')->only(['store']);
        $this->middleware('permission:menus.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:menus.update')->only(['update']);
        $this->middleware('permission:menus.delete')->only(['destroy', 'bulkDestroy']);

        $this->menuItemService = $menuItemService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $menuItems = MenuItem::all();

        return $this->json(MenuItemResource::collection($menuItems), Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated()
    {
        $menuItems = MenuItem::query()
            ->paginate($this->paginationNumber());

        return MenuItemResource::collection($menuItems);
    }

    /**
     * @param MenuItemRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MenuItemRequest $request)
    {
        $menuItem = $this->menuItemService->create($request);

        return $this->json(new MenuItemResource($menuItem), Response::HTTP_CREATED);
    }

    /**
     * @param MenuItem $menuItem
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MenuItem $menuItem)
    {
        return $this->json(new MenuItemResource($menuItem), Response::HTTP_OK);
    }

    /**
     * @param MenuItemRequest $request
     * @param MenuItem $menuItem
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MenuItemRequest $request, MenuItem $menuItem)
    {
        $menuItem = $this->menuItemService->update($menuItem, $request);

        return $this->json(new MenuItemResource($menuItem), Response::HTTP_OK);
    }

    /**
     * @param MenuItem $menuItem
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($menuItem) {
            if ($menuItemToDelete = MenuItem::find($menuItem['id'])) {
                $menuItemToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
