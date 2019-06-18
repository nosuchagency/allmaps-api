<?php

namespace Tests\Feature\MenuItems;

use App\Models\MenuItem;
use App\Models\Poi;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuItemsUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_menu_items()
    {
        $menuItem = factory(MenuItem::class)->create();

        $this->putJson(route('menu-items.update', ['menu_item' => $menuItem]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_menu_items()
    {
        $this->signIn();

        $menuItem = factory(MenuItem::class)->create();

        $this->putJson(route('menu-items.update', ['menu_item' => $menuItem]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_menu_items()
    {
        $menuItem = factory(MenuItem::class)->create();

        $attributes = ['id' => $menuItem->id, 'name' => $this->faker->name];

        $this->update($menuItem, $attributes)->assertOk();

        $this->assertDatabaseHas('menu_items', $attributes);
    }

    /**
     * @param $menuItem
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function update($menuItem, $attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['menus.update'])
        );

        return $this->putJson(route('menu-items.update', ['menu_item' => $menuItem]), $this->validFields($attributes));
    }

    /**
     * @param array $overrides
     *
     * @return array
     */
    protected function validFields($overrides = [])
    {
        return array_merge([
            'name' => $this->faker->name,
            'type' => 'poi',
            'model' => factory(Poi::class)->create()
        ], $overrides);
    }
}
