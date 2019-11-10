<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class BeaconPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any beacons.
     *
     * @param Authorizable $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the beacon.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon:read')->exists();
    }

    /**
     * Determine whether the authorizable can create beacons.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the beacon.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the beacon.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon:delete')->exists();
    }
}
