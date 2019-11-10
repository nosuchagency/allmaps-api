<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class ContainerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any containers.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'container:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the container.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'container:read')->exists();
    }

    /**
     * Determine whether the authorizable can create containers.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'container:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the container.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'container:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the container.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'container:delete')->exists();
    }
}
