<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any roles.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'role:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the role.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'role:read')->exists();
    }

    /**
     * Determine whether the authorizable can create roles.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'role:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the role.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'role:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the role.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'role:delete')->exists();
    }
}
