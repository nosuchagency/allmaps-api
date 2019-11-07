<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StructurePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any structures.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions()->where('name', 'structure:read')->exists();
    }

    /**
     * Determine whether the user can view the structure.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role->permissions()->where('name', 'structure:read')->exists();
    }

    /**
     * Determine whether the user can create structures.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions()->where('name', 'structure:create')->exists();
    }

    /**
     * Determine whether the user can update the structure.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->permissions()->where('name', 'structure:update')->exists();
    }

    /**
     * Determine whether the user can delete the structure.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->permissions()->where('name', 'structure:delete')->exists();
    }
}
