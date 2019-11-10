<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class ActivityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any activities.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'activity:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the activity.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'activity:read')->exists();
    }

    /**
     * Determine whether the authorizable can create activities.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'activity:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the activity.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'activity:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the activity.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'activity:delete')->exists();
    }
}
