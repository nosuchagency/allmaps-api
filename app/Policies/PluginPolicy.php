<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class PluginPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any plugins.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'plugin:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the plugin.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'plugin:read')->exists();
    }

    /**
     * Determine whether the authorizable can create plugins.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'plugin:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the plugin.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'plugin:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the plugin.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'plugin:delete')->exists();
    }
}
