<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class HitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any hits.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'hit:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the hit.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'hit:read')->exists();
    }

    /**
     * Determine whether the authorizable can create hits.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'hit:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the hit.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'hit:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the hit.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'hit:delete')->exists();
    }
}
