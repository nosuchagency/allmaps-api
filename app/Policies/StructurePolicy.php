<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class StructurePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any structures.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'structure:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the structure.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'structure:read')->exists();
    }

    /**
     * Determine whether the authorizable can create structures.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'structure:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the structure.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'structure:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the structure.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'structure:delete')->exists();
    }
}
