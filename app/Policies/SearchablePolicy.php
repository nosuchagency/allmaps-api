<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SearchablePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any searchables.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions()->where('name', 'searchable:read')->exists();
    }

    /**
     * Determine whether the user can view the searchable.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role->permissions()->where('name', 'searchable:read')->exists();
    }

    /**
     * Determine whether the user can create searchables.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions()->where('name', 'searchable:create')->exists();
    }

    /**
     * Determine whether the user can update the searchable.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->permissions()->where('name', 'searchable:update')->exists();
    }

    /**
     * Determine whether the user can delete the searchable.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->permissions()->where('name', 'searchable:delete')->exists();
    }
}
