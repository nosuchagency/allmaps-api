<?php

namespace App\Models;

use App\Filters\SearchFilter;
use Illuminate\Database\Eloquent\Builder;
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
     * @param iterable $permissions
     */
    public function setPermissions(iterable $permissions)
    {
        $this->syncPermissions([]);

        collect($permissions)->each(function ($permission) {
            $permission = Permission::where('name', $permission)->first();

            if ($permission) {
                $this->givePermissionTo($permission->name);
            }
        });
    }
}
