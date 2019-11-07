<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PluginPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any plugins.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions()->where('name', 'plugin:read')->exists();
    }

    /**
     * Determine whether the user can view the plugin.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role->permissions()->where('name', 'plugin:read')->exists();
    }

    /**
     * Determine whether the user can create plugins.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions()->where('name', 'plugin:create')->exists();
    }

    /**
     * Determine whether the user can update the plugin.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->permissions()->where('name', 'plugin:update')->exists();
    }

    /**
     * Determine whether the user can delete the plugin.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->permissions()->where('name', 'plugin:delete')->exists();
    }
}
