<?php

namespace Tests\Feature\Menus;

use App\Models\Menu;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenusUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_menus()
    {
        $menu = factory(Menu::class)->create();

        $this->putJson(route('menus.update', ['menu' => $menu]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_menus()
    {
        $this->signIn();

        $menu = factory(Menu::class)->create();

        $this->putJson(route('menus.update', ['menu' => $menu]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_menus()
    {
        $menu = factory(Menu::class)->create();

        $attributes = ['id' => $menu->id, 'name' => $this->faker->name];

        $this->update($menu, $attributes)->assertOk();

        $this->assertDatabaseHas('menus', $attributes);
    }

    /**
     * @param $menu
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function update($menu, $attributes = [])
    {
        $role = $this->createRoleWithPermissions(['menu:update']);

        $this->signIn(null, $role);

        return $this->putJson(route('menus.update', ['menu' => $menu]), $this->validFields($attributes));
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
        ], $overrides);
    }
}
