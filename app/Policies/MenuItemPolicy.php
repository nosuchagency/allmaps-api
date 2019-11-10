<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class MenuItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any menu items.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'menu-item:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the menu item.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'menu-item:read')->exists();
    }

    /**
     * Determine whether the authorizable can create menu items.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'menu-item:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the menu item.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'menu-item:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the menu item.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'menu-item:delete')->exists();
    }
}
