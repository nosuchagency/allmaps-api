<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class ImportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any imports.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'import:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the import.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'import:read')->exists();
    }

    /**
     * Determine whether the authorizable can create imports.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'import:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the import.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'import:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the import.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'import:delete')->exists();
    }
}
