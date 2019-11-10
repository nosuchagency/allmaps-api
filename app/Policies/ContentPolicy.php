<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class ContentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any contents.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'content:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the content.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'content:read')->exists();
    }

    /**
     * Determine whether the authorizable can create contents.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'content:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the content.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'content:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the content.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'content:delete')->exists();
    }
}
