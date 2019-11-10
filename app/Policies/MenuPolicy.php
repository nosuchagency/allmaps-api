<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class MenuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any menus.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'menu:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the menu.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'menu:read')->exists();
    }

    /**
     * Determine whether the authorizable can create menus.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'menu:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the menu.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'menu:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the menu.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'menu:delete')->exists();
    }
}
