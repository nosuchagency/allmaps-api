<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class FixturePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any fixtures.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'fixture:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the fixture.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'fixture:read')->exists();
    }

    /**
     * Determine whether the authorizable can create fixtures.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'fixture:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the fixture.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'fixture:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the fixture.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'fixture:delete')->exists();
    }
}
