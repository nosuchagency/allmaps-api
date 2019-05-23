<?php

namespace Tests\Feature\Buildings;

use App\Models\Building;
use App\Models\Menu;
use App\Models\Place;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuildingsCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_buildings()
    {
        $this->postJson(route('buildings.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_buildings()
    {
        $this->signIn();

        $this->postJson(route('buildings.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_buildings()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(1, Building::all());
    }

    /** @test */
    public function a_building_requires_a_name()
    {
        $this->create(['name' => null])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function a_building_requires_a_valid_latitude()
    {
        $this->create(['latitude' => 'not-a-valid-latitude'])->assertJsonValidationErrors('latitude');
    }

    /** @test */
    public function a_building_requires_a_valid_longitude()
    {
        $this->create(['longitude' => 'not-a-valid-longitude'])->assertJsonValidationErrors('longitude');
    }

    /** @test */
    public function a_building_requires_a_place()
    {
        $this->create(['place' => null])->assertJsonValidationErrors('place');
    }

    /** @test */
    public function menu_needs_to_be_a_valid_menu_object()
    {
        $this->create(['menu' => ['id' => 2]])->assertJsonValidationErrors(['menu.id']);
        $this->create(['menu' => ['not-a-valid-menu-object']])->assertJsonValidationErrors(['menu']);
    }

    /**
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function create($attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['buildings.create'])
        );

        return $this->postJson(route('buildings.store'), $this->validFields($attributes));
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
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'image' => null,
            'place' => factory(Place::class)->create(),
            'menu' => factory(Menu::class)->create()
        ], $overrides);
    }
}
