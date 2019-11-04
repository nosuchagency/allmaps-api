<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $skinsDirectory;

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

    protected function createSkinsDirectory()
    {
        $this->skinsDirectory = public_path(config('all-maps.skins.directory'));

        if (!File::isDirectory($this->skinsDirectory)) {
            File::makeDirectory($this->skinsDirectory, 0755, true);
        }
    }

    protected function removeSkinsDirectory()
    {
        if (File::isDirectory($this->skinsDirectory)) {
            File::deleteDirectory($this->skinsDirectory);
        }
    }

    protected function addDirectory($directoryName)
    {
        if (!File::isDirectory($this->skinsDirectory . $directoryName)) {
            File::makeDirectory($this->skinsDirectory . $directoryName);
        }
    }

    protected function addFile($stubPath, $directory)
    {
        $path = base_path('tests/Stubs/' . $stubPath);

        File::put($this->skinsDirectory . $directory . '/index.html', File::get($path));
    }

}
