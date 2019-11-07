<?php

namespace App\Services\Models;

use App\Models\Role;
use Illuminate\Support\Arr;

class RoleService
{
    /**
     * @param array $attributes
     *
     * @return Role
     */
    public function create(array $attributes): Role
    {
        $role = new Role();

        $fields = Arr::only($attributes, [
            'name',
        ]);

        $role->fill($fields)->save();

        return $role->refresh();
    }

    /**
     * @param Role $role
     * @param array $attributes
     *
     * @return Role
     */
    public function update(Role $role, array $attributes): Role
    {
        $fields = Arr::only($attributes, [
            'name',
        ]);

        $role->fill($fields)->save();

        return $role->refresh();
    }
}
