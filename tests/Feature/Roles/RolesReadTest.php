<?php

namespace Tests\Feature\Roles;

use App\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolesReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_roles()
    {
        $role = factory(Role::class)->create();

        $this->getJson(route('roles.index'))->assertStatus(401);
        $this->getJson(route('roles.show', ['role' => $role]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_roles()
    {
        $this->signIn();

        $this->getJson(route('roles.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_roles()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['roles.read'])
        );

        $this->getJson(route('roles.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_roles_paginated()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['roles.read'])
        );

        $this->getJson(route('roles.paginated'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_role()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['roles.read'])
        );

        $role = factory(Role::class)->create();

        $this->getJson(route('roles.show', ['role' => $role]))->assertOk();
    }
}
