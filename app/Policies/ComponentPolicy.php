<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class ComponentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any components.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'component:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the component.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'component:read')->exists();
    }

    /**
     * Determine whether the authorizable can create components.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'component:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the component.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'component:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the component.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'component:delete')->exists();
    }
}
