<?php

namespace Tests\Feature\Buildings;

use App\Models\Building;
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
    public function a_building_requires_a_place()
    {
        $this->create(['place' => null])->assertJsonValidationErrors('place');
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
            'name' => $this->faker->title,
            'image' => null,
            'place' => factory(Place::class)->create()
        ], $overrides);
    }
}
