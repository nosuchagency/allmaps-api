<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BeaconContainerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any beacon containers.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon:read')->exists()
            && $user->role->permissions()->where('name', 'container:read')->exists();
    }

    /**
     * Determine whether the user can view the beacon container.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon:read')->exists()
            && $user->role->permissions()->where('name', 'container:read')->exists();
    }

    /**
     * Determine whether the user can create beacon containers.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon:create')->exists()
            && $user->role->permissions()->where('name', 'container:create')->exists();
    }

    /**
     * Determine whether the user can update the beacon container.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon:update')->exists()
            && $user->role->permissions()->where('name', 'container:update')->exists();
    }

    /**
     * Determine whether the user can delete the beacon container.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->permissions()->where('name', 'beacon:delete')->exists()
            && $user->role->permissions()->where('name', 'container:delete')->exists();
    }
}
