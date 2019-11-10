<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class BeaconProviderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any beacon providers.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon-provider:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the beacon provider.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon-provider:read')->exists();
    }

    /**
     * Determine whether the authorizable can create beacon providers.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon-provider:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the beacon provider.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon-provider:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the beacon provider.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'beacon-provider:delete')->exists();
    }
}
