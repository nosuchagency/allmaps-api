<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BeaconProviderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any beacon providers.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon-provider:read')->exists();
    }

    /**
     * Determine whether the user can view the beacon provider.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon-provider:read')->exists();
    }

    /**
     * Determine whether the user can create beacon providers.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon-provider:create')->exists();
    }

    /**
     * Determine whether the user can update the beacon provider.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon-provider:update')->exists();
    }

    /**
     * Determine whether the user can delete the beacon provider.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon-provider:delete')->exists();
    }
}
