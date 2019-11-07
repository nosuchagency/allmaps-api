<?php

namespace Tests\Feature\Roles;

use App\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolesDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_roles()
    {
        $this->postJson(route('roles.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('roles.destroy', ['role' => factory(Role::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_roles()
    {
        $this->signIn();
        $role = factory(Role::class)->create();
        $this->deleteJson(route('roles.destroy', ['role' => $role]))->assertStatus(403);

        $this->postJson(route('roles.bulk-destroy'), ['items' => []])->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_specific_role()
    {
        $role = $this->createRoleWithPermissions(['role:delete']);

        $this->signIn(null, $role);

        $role = factory(Role::class)->create();
        $this->deleteJson(route('roles.destroy', ['role' => $role]))->assertOk();
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_roles_in_bulk()
    {
        $role = $this->createRoleWithPermissions(['role:delete']);

        $this->signIn(null, $role);

        $roles = factory(Role::class, 5)->create();
        $this->assertCount(6, Role::all());
        $this->postJson(route('roles.bulk-destroy'), ['items' => $roles])->assertOk();
        $this->assertCount(1, Role::all());
    }
}
