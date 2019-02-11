<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{

    /**
     * RolesController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:roles.create')->only(['store']);
        $this->middleware('permission:roles.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:roles.update')->only(['update', 'grantPermission']);
        $this->middleware('permission:roles.delete')->only(['destroy', 'bulkDestroy', 'revokePermission']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $roles = Role::all();

        return response()->json(RoleResource::collection($roles), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $roles = Role::filter($request)->paginate($this->paginationNumber());

        return RoleResource::collection($roles);
    }

    /**
     * @param RoleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create($request->only('name'));

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
     * @param Role $role
     * @param RoleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Role $role, RoleRequest $request)
    {
        $role->fill($request->validated())->save();

        return response()->json(new RoleResource($role), Response::HTTP_OK);
    }

    /**
     * @param Role $role
     * @param $permission
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function grantPermission(Role $role, Permission $permission)
    {
        $role->givePermissionTo($permission->name);

        return response()->json(new RoleResource($role), Response::HTTP_OK);
    }

    /**
     * @param Role $role
     * @param $permission
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function revokePermission(Role $role, Permission $permission)
    {
        $role->revokePermissionTo($permission->name);

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
