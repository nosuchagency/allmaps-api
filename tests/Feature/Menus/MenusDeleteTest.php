<?php

namespace Tests\Feature\Menus;

use App\Models\Menu;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenusDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_menus()
    {
        $this->postJson(route('menus.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('menus.destroy', ['menu' => factory(Menu::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_menus()
    {
        $this->signIn();
        $menu = factory(Menu::class)->create();
        $this->deleteJson(route('menus.destroy', ['menu' => $menu]))->assertStatus(403);

        $this->postJson(route('menus.bulk-destroy'), ['items' => []])->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_specific_menu()
    {
        $role = $this->createRoleWithPermissions(['menu:delete']);

        $this->signIn(null, $role);

        $menu = factory(Menu::class)->create();
        $this->deleteJson(route('menus.destroy', ['menu' => $menu]))->assertOk();
        $this->assertSoftDeleted('menus', ['id' => $menu->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_menus_in_bulk()
    {
        $role = $this->createRoleWithPermissions(['menu:delete']);

        $this->signIn(null, $role);

        $menus = factory(Menu::class, 5)->create();
        $this->assertCount(5, Menu::all());
        $this->postJson(route('menus.bulk-destroy'), ['items' => $menus])->assertOk();
        $this->assertCount(0, Menu::all());
    }
}
