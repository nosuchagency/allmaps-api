<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContainerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any containers.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions()->where('name', 'container:read')->exists();
    }

    /**
     * Determine whether the user can view the container.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role->permissions()->where('name', 'container:read')->exists();
    }

    /**
     * Determine whether the user can create containers.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions()->where('name', 'container:create')->exists();
    }

    /**
     * Determine whether the user can update the container.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->permissions()->where('name', 'container:update')->exists();
    }

    /**
     * Determine whether the user can delete the container.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->permissions()->where('name', 'container:delete')->exists();
    }
}
