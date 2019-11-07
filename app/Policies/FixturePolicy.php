<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FixturePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any fixtures.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->permissions()->where('name', 'fixture:read')->exists();
    }

    /**
     * Determine whether the user can view the fixture.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role->permissions()->where('name', 'fixture:read')->exists();
    }

    /**
     * Determine whether the user can create fixtures.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->permissions()->where('name', 'fixture:create')->exists();
    }

    /**
     * Determine whether the user can update the fixture.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->permissions()->where('name', 'fixture:update')->exists();
    }

    /**
     * Determine whether the user can delete the fixture.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->permissions()->where('name', 'fixture:delete')->exists();
    }
}
