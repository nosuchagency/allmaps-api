<?php

namespace Tests\Feature\Structures;

use App\Models\Floor;
use App\Models\Component;
use App\Models\Structure;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StructuresCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_structures()
    {
        $this->postJson(route('structures.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_structures()
    {
        $this->signIn();

        $this->postJson(route('structures.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_structures()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(1, Structure::all());
    }

    /** @test */
    public function a_structure_requires_a_floor()
    {
        $this->create(['floor' => null])->assertJsonValidationErrors(['floor', 'floor.id']);
    }

    /** @test */
    public function a_structure_requires_a_component()
    {
        $this->create(['component' => null])->assertJsonValidationErrors('component');
    }

    /** @test */
    public function a_structure_requires_coordinates_to_be_an_array()
    {
        $this->create(['coordinates' => 'not-an-array'])->assertJsonValidationErrors('coordinates');
    }

    /** @test */
    public function a_structure_requires_markers_to_be_an_array()
    {
        $this->create(['markers' => 'not-an-array'])->assertJsonValidationErrors('markers');
    }

    /**
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function create($attributes = [])
    {
        $role = $this->createRoleWithPermissions(['structure:create']);

        $this->signIn(null, $role);

        return $this->postJson(route('structures.store'), $this->validFields($attributes));
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
            'coordinates' => [],
            'markers' => [],
            'radius' => 5,
            'component' => factory(Component::class)->create(),
            'floor' => factory(Floor::class)->create()
        ], $overrides);
    }
}
