<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BeaconPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any beacons.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon:read')->exists();
    }

    /**
     * Determine whether the user can view the beacon.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon:read')->exists();
    }

    /**
     * Determine whether the user can create beacons.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon:create')->exists();
    }

    /**
     * Determine whether the user can update the beacon.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon:update')->exists();
    }

    /**
     * Determine whether the user can delete the beacon.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon:delete')->exists();
    }
}
