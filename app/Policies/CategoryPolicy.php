<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any categories.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'category:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the category.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'category:read')->exists();
    }

    /**
     * Determine whether the authorizable can create categories.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'category:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the category.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'category:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the category.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'category:delete')->exists();
    }
}
