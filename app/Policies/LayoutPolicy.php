<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LayoutPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any layouts.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions()->where('name', 'layout:read')->exists();
    }

    /**
     * Determine whether the user can view the layout.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role->permissions()->where('name', 'layout:read')->exists();
    }

    /**
     * Determine whether the user can create layouts.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions()->where('name', 'layout:create')->exists();
    }

    /**
     * Determine whether the user can update the layout.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->permissions()->where('name', 'layout:update')->exists();
    }

    /**
     * Determine whether the user can delete the layout.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->permissions()->where('name', 'layout:delete')->exists();
    }
}
