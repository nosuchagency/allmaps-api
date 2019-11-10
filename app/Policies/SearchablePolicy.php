<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class SearchablePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any searchables.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'searchable:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the searchable.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'searchable:read')->exists();
    }

    /**
     * Determine whether the authorizable can create searchables.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'searchable:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the searchable.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'searchable:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the searchable.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'searchable:delete')->exists();
    }
}
