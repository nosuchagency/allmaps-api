<?php

namespace Tests\Feature\MenuItems;

use App\Models\MenuItem;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuItemsReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_menu_items()
    {
        $menuItem = factory(MenuItem::class)->create();

        $this->getJson(route('menu-items.index'))->assertStatus(401);
        $this->getJson(route('menu-items.show', ['menu_item' => $menuItem]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_menu_items()
    {
        $this->signIn();

        $this->getJson(route('menu-items.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_menu_items()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['menus.read'])
        );

        $this->getJson(route('menu-items.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_menu_items_paginated()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['menus.read'])
        );

        $this->getJson(route('menu-items.paginated'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_menu_item()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['menus.read'])
        );

        $menuItem = factory(MenuItem::class)->create();

        $this->getJson(route('menu-items.show', ['menu_item' => $menuItem]))->assertOk();
    }
}
