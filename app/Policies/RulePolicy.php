<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Access\Authorizable;

class RulePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the authorizable can view any rules.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function viewAny(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'rule:read')->exists();
    }

    /**
     * Determine whether the authorizable can view the rule.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function view(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'rule:read')->exists();
    }

    /**
     * Determine whether the authorizable can create rules.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function create(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'rule:create')->exists();
    }

    /**
     * Determine whether the authorizable can update the rule.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function update(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'rule:update')->exists();
    }

    /**
     * Determine whether the authorizable can delete the rule.
     *
     * @param $authorizable
     *
     * @return mixed
     */
    public function delete(Authorizable $authorizable)
    {
        return $authorizable->role->permissions()->where('name', 'rule:delete')->exists();
    }
}
