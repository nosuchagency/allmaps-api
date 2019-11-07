<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PoiPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any pois.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions()->where('name', 'poi:read')->exists();
    }

    /**
     * Determine whether the user can view the poi.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role->permissions()->where('name', 'poi:read')->exists();
    }

    /**
     * Determine whether the user can create pois.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions()->where('name', 'poi:create')->exists();
    }

    /**
     * Determine whether the user can update the poi.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->permissions()->where('name', 'poi:update')->exists();
    }

    /**
     * Determine whether the user can delete the poi.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->permissions()->where('name', 'poi:delete')->exists();
    }
}
