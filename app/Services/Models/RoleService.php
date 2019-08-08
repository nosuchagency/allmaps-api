<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RoleService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $role = new Role();
        $role->fill($request->only('name'))->save();

        if ($request->filled('permissions')) {
            $role->setPermissions($request->get('permissions'));
        }

        return $role->refresh();
    }

    /**
     * @param Model $role
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $role, Request $request)
    {
        $role->fill($request->only('name'))->save();

        if ($request->filled('permissions')) {
            $role->setPermissions($request->get('permissions'));
        }

        return $role->refresh();
    }
}