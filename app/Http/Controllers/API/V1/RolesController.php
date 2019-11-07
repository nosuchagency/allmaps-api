<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Services\Models\RoleService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class RolesController extends Controller
{

    /**
     * @var RoleService
     */
    protected $roleService;

    /**
     * RolesController constructor.
     *
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Role::class);

        $roles = Role::query()
            ->filter($request)
            ->get();

        return $this->json(RoleResource::collection($roles), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Role::class);

        $roles = Role::query()
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return RoleResource::collection($roles);
    }

    /**
     * @param RoleRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(RoleRequest $request)
    {
        $role = $this->roleService->create($request->validated());

        return $this->json(new RoleResource($role), Response::HTTP_CREATED);
    }

    /**
     * @param Role $role
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Role $role)
    {
        $this->authorize('view', Role::class);

        return $this->json(new RoleResource($role), Response::HTTP_OK);
    }

    /**
     * @param RoleRequest $request
     * @param Role $role
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role = $this->roleService->update($role, $request->validated());

        return $this->json(new RoleResource($role), Response::HTTP_OK);
    }

    /**
     * @param Role $role
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', Role::class);

        $role->delete();

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
        $this->authorize('delete', Role::class);

        collect($request->get('items'))->each(function ($role) {
            if ($roleToDelete = Role::find($role['id'])) {
                $roleToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
