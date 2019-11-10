<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class PlacePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any places.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'place:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the place.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'place:read')->exists();
    }

    /**
     * Determine whether the authorizable can create places.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'place:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the place.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'place:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the place.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'place:delete')->exists();
    }
}
