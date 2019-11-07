<?php

namespace Tests\Feature\Floors;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FloorsCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_floors()
    {
        $this->postJson(route('floors.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_floors()
    {
        $this->signIn();

        $this->postJson(route('floors.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_floors()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(1, Floor::all());
    }

    /** @test */
    public function a_floor_requires_a_name()
    {
        $this->create(['name' => null])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function a_floor_requires_a_building()
    {
        $this->create(['building' => null])->assertJsonValidationErrors('building');
    }

    /**
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function create($attributes = [])
    {
        $role = $this->createRoleWithPermissions(['floor:create']);

        $this->signIn(null, $role);

        return $this->postJson(route('floors.store'), $this->validFields($attributes));
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
            'level' => $this->faker->randomNumber(),
            'image' => null,
            'building' => factory(Building::class)->create()
        ], $overrides);
    }
}
