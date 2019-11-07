<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SkinPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any skins.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions()->where('name', 'skin:read')->exists();
    }

    /**
     * Determine whether the user can view the skin.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role->permissions()->where('name', 'skin:read')->exists();
    }

    /**
     * Determine whether the user can create skins.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions()->where('name', 'skin:create')->exists();
    }

    /**
     * Determine whether the user can update the skin.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->permissions()->where('name', 'skin:update')->exists();
    }

    /**
     * Determine whether the user can delete the skin.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->permissions()->where('name', 'skin:delete')->exists();
    }
}
