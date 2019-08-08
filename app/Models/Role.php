<?php

namespace App\Models;

use App\Filters\SearchFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Permission;

class Role extends \Spatie\Permission\Models\Role
{
    use LogsActivity;

    /**
     * Process filters
     *
     * @param Builder $builder
     * @param $request
     *
     * @return Builder $builder
     */
    public function scopeFilter(Builder $builder, $request)
    {
        return (new SearchFilter($request))->filter($builder);
    }

    /**
     * @return Collection|Permission[]
     */
    public function getPermissions()
    {
        $rolePermissions = $this->permissions->pluck('name');

        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            if ($rolePermissions->contains($permission->name)) {
                $permission->possessed = true;
            } else {
                $permission->possessed = false;
            }
        }

        return $permissions;
    }

    /**
     * @param array $permissions
     *
     * @return void
     */
    public function setPermissions(array $permissions)
    {
        foreach ($permissions as $permission) {
            if (!isset($permission['possessed'], $permission['name'])) {
                continue;
            }

            if ($permission['possessed']) {
                $this->givePermissionTo($permission['name']);
            } else {
                $this->revokePermissionTo($permission['name']);
            }
        }
    }
}
