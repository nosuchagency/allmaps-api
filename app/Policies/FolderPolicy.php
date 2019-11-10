<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class FolderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any folders.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'folder:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the folder.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'folder:read')->exists();
    }

    /**
     * Determine whether the authorizable can create folders.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'folder:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the folder.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'folder:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the folder.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'folder:delete')->exists();
    }
}
