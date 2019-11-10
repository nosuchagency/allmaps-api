<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class TokenPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any tokens.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'token:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the token.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'token:read')->exists();
    }

    /**
     * Determine whether the authorizable can create tokens.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'token:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the token.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'token:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the token.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'token:delete')->exists();
    }
}
