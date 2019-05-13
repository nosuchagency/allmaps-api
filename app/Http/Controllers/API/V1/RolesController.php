<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Services\Models\RoleService;
use Illuminate\Http\Request;
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
        $this->middleware('permission:roles.create')->only(['store']);
        $this->middleware('permission:roles.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:roles.update')->only(['update', 'grantPermission']);
        $this->middleware('permission:roles.delete')->only(['destroy', 'bulkDestroy', 'revokePermission']);

        $this->roleService = $roleService;
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $roles = Role::query()
            ->filter($request)
            ->get();

        return response()->json(RoleResource::collection($roles), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $roles = Role::query()
            ->filter($request)
            ->paginate($this->paginationNumber());

        return RoleResource::collection($roles);
    }

    /**
     * @param RoleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request)
    {
        $role = $this->roleService->create($request);

        return response()->json(new RoleResource($role), Response::HTTP_CREATED);
    }

    /**
     * @param Role $role
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        return response()->json(new RoleResource($role), Response::HTTP_OK);
    }

    /**
     * @param RoleRequest $request
     * @param Role $role
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role = $this->roleService->update($role, $request);

        return response()->json(new RoleResource($role), Response::HTTP_OK);
    }

    /**
     * @param Role $role
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($role) {
            if ($roleToDelete = Role::find($role['id'])) {
                $roleToDelete->delete();
            }
        });

        return response()->json(null, Response::HTTP_OK);
    }
}
