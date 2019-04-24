<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Permission;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param User $user
     *
     * @return User
     */
    protected function signIn($user = null): User
    {
        $user = $user ?? factory(User::class)->create();
        $this->actingAs($user);
        return $user;
    }

    /**
     * Set the currently logged in user for the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string|null $driver
     *
     * @return $this
     */
    public function actingAs(UserContract $user, $driver = null)
    {
        $token = JWTAuth::fromUser($user);
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ]);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return Permission
     */
    public function createPermission(string $name): Permission
    {
        return Permission::firstOrCreate([
            'name' => $name,
            'guard_name' => 'api'
        ]);
    }

    /**
     * @param array $permissions
     *
     * @return Role
     */
    public function createRoleWithPermissions(array $permissions = []): Role
    {
        $role = factory(Role::class)->create();

        foreach ($permissions as $permission) {
            $role->givePermissionTo(
                $this->createPermission($permission)->name
            );
        }

        return $role;
    }

}
