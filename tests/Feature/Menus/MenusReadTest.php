<?php

namespace Tests\Feature\Menus;

use App\Models\Menu;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenusReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_menu()
    {
        $menu = factory(Menu::class)->create();

        $this->getJson(route('menus.index'))->assertStatus(401);
        $this->getJson(route('menus.show', ['menu' => $menu]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_menus()
    {
        $this->signIn();

        $this->getJson(route('menus.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_menus()
    {
        $role = $this->createRoleWithPermissions(['menu:read']);

        $this->signIn(null, $role);

        $this->getJson(route('menus.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_menus_paginated()
    {
        $role = $this->createRoleWithPermissions(['menu:read']);

        $this->signIn(null, $role);

        $this->getJson(route('menus.paginated'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_menu()
    {
        $role = $this->createRoleWithPermissions(['menu:read']);

        $this->signIn(null, $role);

        $menu = factory(Menu::class)->create();

        $this->getJson(route('menus.show', ['menu' => $menu]))->assertOk();
    }
}
