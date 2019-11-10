<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any permissions.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'permission:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the permission.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'permission:read')->exists();
    }

    /**
     * Determine whether the authorizable can create permissions.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'permission:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the permission.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'permission:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the permission.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'permission:delete')->exists();
    }
}
