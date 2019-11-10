<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class FloorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any floors.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'floor:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the floor.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'floor:read')->exists();
    }

    /**
     * Determine whether the authorizable can create floors.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'floor:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the floor.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'floor:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the floor.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'floor:delete')->exists();
    }
}
