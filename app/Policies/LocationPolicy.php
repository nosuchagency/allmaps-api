<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class LocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any locations.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'location:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the location.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'location:read')->exists();
    }

    /**
     * Determine whether the authorizable can create locations.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'location:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the location.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'location:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the location.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'location:delete')->exists();
    }
}
