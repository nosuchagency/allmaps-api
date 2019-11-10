<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class BuildingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any buildings.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'building:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the building.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'building:read')->exists();
    }

    /**
     * Determine whether the authorizable can create buildings.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'building:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the building.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'building:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the building.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'building:delete')->exists();
    }
}
