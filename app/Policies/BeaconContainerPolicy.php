<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class BeaconContainerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any beacon containers.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon:read')->exists()
            && $authorizable->role->permissions()->where('name', 'container:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the beacon container.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon:read')->exists()
            && $authorizable->role->permissions()->where('name', 'container:read')->exists();
    }

    /**
     * Determine whether the authorizable can create beacon containers.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon:create')->exists()
            && $authorizable->role->permissions()->where('name', 'container:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the beacon container.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon:update')->exists()
            && $authorizable->role->permissions()->where('name', 'container:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the beacon container.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon:delete')->exists()
            && $authorizable->role->permissions()->where('name', 'container:delete')->exists();
    }
}
