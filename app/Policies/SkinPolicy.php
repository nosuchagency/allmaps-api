<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class SkinPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any skins.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'skin:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the skin.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'skin:read')->exists();
    }

    /**
     * Determine whether the authorizable can create skins.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'skin:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the skin.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'skin:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the skin.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'skin:delete')->exists();
    }
}
