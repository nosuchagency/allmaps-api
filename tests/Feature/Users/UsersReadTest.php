<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_users()
    {
        $user = factory(User::class)->create();

        $this->getJson(route('users.index'))->assertStatus(401);
        $this->getJson(route('users.show', ['user' => $user]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_users()
    {
        $this->signIn();

        $this->getJson(route('users.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_users()
    {
        $role = $this->createRoleWithPermissions(['user:read']);

        $this->signIn(null, $role);

        $this->getJson(route('users.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_users_paginated()
    {
        $role = $this->createRoleWithPermissions(['user:read']);

        $this->signIn(null, $role);

        $this->getJson(route('users.paginated'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_user()
    {
        $role = $this->createRoleWithPermissions(['user:read']);

        $this->signIn(null, $role);

        $user = factory(User::class)->create();

        $this->getJson(route('users.show', ['user' => $user]))->assertOk();
    }
}
