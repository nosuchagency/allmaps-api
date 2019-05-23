<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Services\Models\MenuService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenusController extends Controller
{

    /**
     * @var MenuService
     */
    protected $menuService;

    /**
     * MenusController constructor.
     *
     * @param MenuService $menuService
     */
    public function __construct(MenuService $menuService)
    {
        $this->middleware('permission:menus.create')->only(['store']);
        $this->middleware('permission:menus.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:menus.update')->only(['update']);
        $this->middleware('permission:menus.delete')->only(['destroy', 'bulkDestroy']);

        $this->menuService = $menuService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $menus = Menu::query()
            ->withRelations($request)
            ->get();

        return $this->json(MenuResource::collection($menus), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $menus = Menu::query()
            ->withRelations($request)
            ->paginate($this->paginationNumber());

        return MenuResource::collection($menus);
    }

    /**
     * @param MenuRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MenuRequest $request)
    {
        $menu = $this->menuService->create($request);

        $menu->load($menu->relationships);

        return $this->json(new MenuResource($menu), Response::HTTP_CREATED);
    }

    /**
     * @param Menu $menu
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Menu $menu)
    {
        $menu->load($menu->relationships);

        return $this->json(new MenuResource($menu), Response::HTTP_OK);
    }

    /**
     * @param MenuRequest $request
     * @param Menu $menu
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $menu = $this->menuService->update($menu, $request);

        $menu->load($menu->relationships);

        return $this->json(new MenuResource($menu), Response::HTTP_OK);
    }

    /**
     * @param Menu $menu
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($menu) {
            if ($menuToDelete = Menu::find($menu['id'])) {
                $menuToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
