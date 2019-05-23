<?php

namespace Tests\Feature\MenuItems;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuItemsCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_menu_items()
    {
        $this->postJson(route('menu-items.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_menu_items()
    {
        $this->signIn();

        $this->postJson(route('menu-items.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_menu_items()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(1, MenuItem::all());
    }

    /** @test */
    public function a_menu_item_requires_a_name()
    {
        $this->create(['name' => null])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function a_menu_item_requires_a_menu()
    {
        $this->create(['menu' => null])->assertJsonValidationErrors('menu');
    }

    /** @test */
    public function a_menu_item_requires_a_type()
    {
        $this->create(['type' => null])->assertJsonValidationErrors('type');
    }

    /** @test */
    public function if_type_is_poi_poi_is_required()
    {
        $this->create(['type' => 'poi', 'poi' => null])->assertJsonValidationErrors('poi');
    }

    /** @test */
    public function if_type_is_location_location_is_required()
    {
        $this->create(['type' => 'location', 'location' => null])->assertJsonValidationErrors('location');
    }

    /** @test */
    public function if_type_is_tag_tag_is_required()
    {
        $this->create(['type' => 'tag', 'tag' => null])->assertJsonValidationErrors('tag');
    }

    /** @test */
    public function if_type_is_category_category_is_required()
    {
        $this->create(['type' => 'category', 'category' => null])->assertJsonValidationErrors('category');
    }

    /**
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function create($attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['menus.create'])
        );

        return $this->postJson(route('menu-items.store'), $this->validFields($attributes));
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
            'menu' => factory(Menu::class)->create(),
            'type' => 'header',
        ], $overrides);
    }
}
