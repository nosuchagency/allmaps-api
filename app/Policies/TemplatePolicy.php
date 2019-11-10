<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class TemplatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any templates.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'template:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the template.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'template:read')->exists();
    }

    /**
     * Determine whether the authorizable can create templates.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'template:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the template.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'template:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the template.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'template:delete')->exists();
    }
}
