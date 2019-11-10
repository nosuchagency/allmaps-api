<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class PoiPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any pois.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'poi:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the poi.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'poi:read')->exists();
    }

    /**
     * Determine whether the authorizable can create pois.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'poi:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the poi.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'poi:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the poi.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'poi:delete')->exists();
    }
}
