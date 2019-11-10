<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class LayoutPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any layouts.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'layout:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the layout.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'layout:read')->exists();
    }

    /**
     * Determine whether the authorizable can create layouts.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'layout:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the layout.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'layout:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the layout.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'layout:delete')->exists();
    }
}
