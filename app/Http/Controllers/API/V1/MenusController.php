<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Services\Models\MenuService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
        $this->menuService = $menuService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Menu::class);

        $menus = Menu::query()
            ->filter($request)
            ->withRelations($request)
            ->get();

        return $this->json(MenuResource::collection($menus), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Menu::class);

        $menus = Menu::query()
            ->filter($request)
            ->withRelations($request)
            ->jsonPaginate($this->paginationNumber());

        return MenuResource::collection($menus);
    }

    /**
     * @param MenuRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(MenuRequest $request)
    {
        $menu = $this->menuService->create($request->validated());

        $menu->load($menu->relationships);

        return $this->json(new MenuResource($menu), Response::HTTP_CREATED);
    }

    /**
     * @param Menu $menu
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Menu $menu)
    {
        $this->authorize('view', Menu::class);

        $menu->load($menu->relationships);

        return $this->json(new MenuResource($menu), Response::HTTP_OK);
    }

    /**
     * @param MenuRequest $request
     * @param Menu $menu
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $menu = $this->menuService->update($menu, $request->validated());

        $menu->load($menu->relationships);

        return $this->json(new MenuResource($menu), Response::HTTP_OK);
    }

    /**
     * @param Menu $menu
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Menu $menu)
    {
        $this->authorize('delete', Menu::class);

        $menu->delete();

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
        $this->authorize('delete', Menu::class);

        collect($request->get('items'))->each(function ($menu) {
            if ($menuToDelete = Menu::find($menu['id'])) {
                $menuToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
