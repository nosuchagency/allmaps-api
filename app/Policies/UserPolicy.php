<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any users.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'user:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the user.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'user:read')->exists();
    }

    /**
     * Determine whether the authorizable can create users.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'user:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the user.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'user:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the user.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'user:delete')->exists();
    }
}
