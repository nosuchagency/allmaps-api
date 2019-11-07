<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any hits.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions()->where('name', 'hit:read')->exists();
    }

    /**
     * Determine whether the user can view the hit.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role->permissions()->where('name', 'hit:read')->exists();
    }

    /**
     * Determine whether the user can create hits.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions()->where('name', 'hit:create')->exists();
    }

    /**
     * Determine whether the user can update the hit.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->permissions()->where('name', 'hit:update')->exists();
    }

    /**
     * Determine whether the user can delete the hit.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->permissions()->where('name', 'hit:delete')->exists();
    }
}
