<?php

namespace Tests\Feature\MenuItems;

use App\Models\Menu;
use App\Models\MenuItem;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuItemsDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_menu_items()
    {
        $this->postJson(route('menu-items.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('menu-items.destroy', ['menu_item' => factory(MenuItem::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_menu_items()
    {
        $this->signIn();
        $menuItem = factory(MenuItem::class)->create();
        $this->deleteJson(route('menu-items.destroy', ['menu_item' => $menuItem]))->assertStatus(403);

        $this->postJson(route('menu-items.bulk-destroy'), ['items' => []])->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_specific_menu_item()
    {
        $role = $this->createRoleWithPermissions(['menu-item:delete']);

        $this->signIn(null, $role);

        $menuItem = factory(MenuItem::class)->create();
        $this->deleteJson(route('menu-items.destroy', ['menu_item' => $menuItem]))->assertOk();
        $this->assertSoftDeleted('menu_items', ['id' => $menuItem->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_menu_items_in_bulk()
    {
        $role = $this->createRoleWithPermissions(['menu-item:delete']);

        $this->signIn(null, $role);

        $menuItems = factory(MenuItem::class, 5)->create();
        $this->assertCount(5, MenuItem::all());
        $this->postJson(route('menu-items.bulk-destroy'), ['items' => $menuItems])->assertOk();
        $this->assertCount(0, MenuItem::all());
    }
}
